<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Collection;

use Nuonic\OnePasswordCli\Model\OnePasswordField;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<OnePasswordField>
 * @implements CollectionInterface<OnePasswordField>
 */
class OnePasswordFieldCollection extends AbstractCollection implements CollectionInterface
{

    public function getType(): string
    {
        return OnePasswordField::class;
    }

    /**
     * @param mixed $offset
     * @param OnePasswordField $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        parent::offsetSet($value->id, $value);
    }

    /**
     * @param OnePasswordField $element
     * @return bool
     */
    public function remove(mixed $element): bool
    {
        if (isset($this->data[$element->id])) {
            unset($this[$element->id]);
            return true;
        }

        return parent::remove($element);
    }

    /**
     * @param OnePasswordField $element
     * @param bool $strict
     * @return bool
     */
    public function contains(mixed $element, bool $strict = true): bool
    {
        return isset($this->data[$element->id]);
    }

    public function toArray(): array
    {
        return array_values($this->data);
    }

    public function find(string $fieldId): ?OnePasswordField
    {
        return $this->fields[$fieldId] ?? null;
    }

    public function filterType(string $type): OnePasswordFieldCollection
    {
        return new OnePasswordFieldCollection(
            array_filter($this->data, static fn (OnePasswordField $field) => $field->type === $type)
        );
    }

    public function filterLabel(string $label): OnePasswordFieldCollection
    {
        return new OnePasswordFieldCollection(
            array_filter($this->data, static fn (OnePasswordField $field) => $field->label === $label)
        );
    }

    /**
     * @return array<string, OnePasswordField>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
