<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Collection;

use JsonSerializable;
use Ramsey\Collection\CollectionInterface as BaseCollectionInterface;

/**
 * @template T
 * @extends BaseCollectionInterface<T>
 */
interface CollectionInterface extends BaseCollectionInterface, JsonSerializable
{
    /**
     * @param T[] $data
     */
    public function __construct(array $data = []);
}
