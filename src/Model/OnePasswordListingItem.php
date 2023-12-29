<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

class OnePasswordListingItem
{
    public OnePasswordItemId $id;
    public string $title;
    public int $version;
    public OnePasswordVaultInfo $vault;
    public string $category;
    public OnePasswordUserId $lastEditedBy;
    public \DateTimeInterface $createdAt;
    public \DateTimeInterface $updatedAt;
    public string $additionalInformation;

    public function setId(string $id): OnePasswordListingItem
    {
        $this->id = new OnePasswordItemId($id);
        return $this;
    }

    public function setLastEditedBy(string $id): OnePasswordListingItem
    {
        $this->lastEditedBy = new OnePasswordUserId($id);
        return $this;
    }
}
