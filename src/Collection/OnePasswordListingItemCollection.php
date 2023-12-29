<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Collection;

use Nuonic\OnePasswordCli\Model\OnePasswordItemId;
use Nuonic\OnePasswordCli\Model\OnePasswordListingItem;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<OnePasswordListingItem>
 * @implements CollectionInterface<OnePasswordListingItem>
 */
class OnePasswordListingItemCollection extends AbstractCollection implements CollectionInterface
{

    public function getType(): string
    {
        return OnePasswordListingItem::class;
    }

    /**
     * @param mixed $offset
     * @param OnePasswordListingItem $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        parent::offsetSet((string) $value->id, $value);
    }

    public function find(OnePasswordItemId $itemId): ?OnePasswordListingItem
    {
        return $this->data[(string) $itemId] ?? null;
    }

    /**
     * @param OnePasswordListingItem $element
     * @return bool
     */
    public function remove(mixed $element): bool
    {
        if (isset($this->data[(string) $element->id])) {
            unset($this[(string) $element->id]);
            return true;
        }

        return parent::remove($element);
    }

    /**
     * @param OnePasswordListingItem $element
     * @param bool $strict
     * @return bool
     */
    public function contains(mixed $element, bool $strict = true): bool
    {
        return isset($this->data[(string) $element->id]);
    }

    public function toArray(): array
    {
        return array_values($this->data);
    }

    /**
     * @return array<string, OnePasswordListingItem>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
