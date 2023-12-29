<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Serializer;

use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectToPopulateTrait;

class ModelDenormalizer implements DenormalizerAwareInterface, DenormalizerInterface
{
    use DenormalizerAwareTrait, ObjectToPopulateTrait;

    /**
     * @var array<string, ReflectionMethod>
     */
    private array $setters;

    /**
     * @var ReflectionProperty[]
     */
    private array $publicVars;

    public function __construct(
        readonly private ?LoggerInterface $logger = null
    ) {}

    /**
     * @template T
     *
     * @throws ExceptionInterface
     * @throws ReflectionException
     * @param mixed[] $data
     * @param class-string<T> $type
     * @param string $format
     * @param mixed[] $context
     * @return T
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $object = $this->extractObjectToPopulate($type, $context) ?? new $type();

        if (!isset($this->setters[$type], $this->publicVars[$type])) {
            $this->discoverMembers($type);
        }

        $setters = $this->setters[$type];
        $publicVars = $this->publicVars[$type];

        foreach ($data as $key => $value) {
            if (str_contains($key, '_')) {
                $key = $this->camelize($key);
            }

            $reflectionType = null;
            if (isset($publicVars[$key])) {
                $reflectionType = $publicVars[$key]->getType();
            }

            if (isset($setters[$key])) {
                $reflectionType = $setters[$key]->getParameters()[0]->getType();
            }

            if (!$reflectionType instanceof ReflectionNamedType) {
                continue;
            }

            if (is_array($value) && $reflectionType->getName() !== 'array') {
                $this->logger?->debug(sprintf(
                    '%s::%s: denormalizing array to object of type %s',
                    $object::class,
                    $key,
                    $reflectionType->getName()
                ), [$object, $key, $context]);
                $value = $this->denormalizer->denormalize($value, $reflectionType->getName(), $format, $context);
            }

            if (is_string($value) && $reflectionType->getName() === 'bool') {
                $this->logger?->debug(sprintf(
                    '%s::%s: converting string bool representation',
                    $object::class,
                    $key
                ), [$object, $key, $context]);
                $value = $value === '1';
            }

            if (!($reflectionType->allowsNull() && is_null($value))
                && $this->determineType($value) !== $reflectionType->getName()
            ) {
                $this->logger?->debug(sprintf(
                    '%s::%s: denormalizing %s to type %s',
                    $object::class,
                    $key,
                    $this->determineType($value),
                    $reflectionType->getName()
                ), [$object, $key, $context]);
                $value = $this->denormalizer->denormalize($value, $reflectionType->getName(), $format, $context);
            }

            if (isset($setters[$key])) {
                $setter = $setters[$key];
                [$object, $setter->name]($value);
                continue;
            }

            if (isset($publicVars[$key])) {
                $property = $publicVars[$key];
                $object->{$property->getName()} = $value;
            }
        }

        return $object;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param mixed[] $context
     * @return bool
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        if (!is_array($data)) {
            return false;
        }

        if (!str_starts_with($type, 'Nuonic\\OnePasswordCli\\Model\\') || str_ends_with($type, '[]')) {
            return false;
        }

        return true;
    }

    /**
     * @param string|null $format
     * @return Array<string, bool>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [
            'object' => true
        ];
    }

    private function determineType(mixed $var): string
    {
        $internalType = gettype($var);
        return match ($internalType) {
            'boolean' => 'bool',
            'integer' => 'int',
            'double' => 'float',
            'NULL' => 'null',
            'object' => get_class($var),
            default => $internalType
        };
    }

    /**
     * @throws ReflectionException
     */
    private function discoverMembers(string $type): void
    {
        $reflectionClass = new ReflectionClass($type);
        $this->publicVars[$type] = $this->discoverProperties($reflectionClass);
        $this->setters[$type] = $this->discoverSetters($reflectionClass);
    }

    /**
     * @param ReflectionClass<object> $reflectionClass
     * @return array<string, ReflectionMethod>
     */
    private function discoverSetters(ReflectionClass $reflectionClass): array
    {
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
        $setters = [];
        foreach ($methods as $method) {
            if ($method->getNumberOfParameters() > 1) {
                continue;
            }

            $methodName = $method->getName();
            if (!str_starts_with($methodName, 'set')) {
                continue;
            }

            $setters[lcfirst(substr($methodName, 3))] = $method;
        }

        return $setters;
    }

    /**
     * @param ReflectionClass<object> $reflectionClass
     * @return ReflectionProperty[]
     */
    private function discoverProperties(ReflectionClass $reflectionClass): array
    {
        $refProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PUBLIC);
        $properties = [];
        foreach ($refProperties as $property) {
            $properties[$property->getName()] = $property;
        }

        return $properties;
    }

    private function camelize(string $input, string $separator = '_'): string
    {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }
}
