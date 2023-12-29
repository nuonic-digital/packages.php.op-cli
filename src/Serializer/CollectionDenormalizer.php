<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Serializer;

use Nuonic\OnePasswordCli\Collection\CollectionInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectToPopulateTrait;

class CollectionDenormalizer implements DenormalizerAwareInterface, DenormalizerInterface
{

    use ObjectToPopulateTrait, DenormalizerAwareTrait;

    /**
     * @template T of CollectionInterface
     *
     * @param mixed[] $data
     * @param class-string<T> $type
     * @param string|null $format
     * @param mixed[] $context
     * @return T
     * @throws ExceptionInterface
     */
    public function denormalize(
        mixed $data,
        string $type,
        string $format = null,
        array $context = []
    ): CollectionInterface {
        $object = $this->extractObjectToPopulate($type, $context) ?? new $type();

        foreach ($data as $item) {
            $object->add(
                $this->denormalizer->denormalize($item, $object->getType(), $format, $context)
            );
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

        if (!is_subclass_of($type, CollectionInterface::class)) {
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
            CollectionInterface::class => true
        ];
    }
}
