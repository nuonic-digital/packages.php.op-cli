<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

use Nuonic\OnePasswordCli\Collection\OnePasswordFieldCollection;

class OnePasswordItem extends OnePasswordListingItem
{
    public OnePasswordFieldCollection $fields;

    public function __construct()
    {
        $this->fields = new OnePasswordFieldCollection();
    }

    public function addField(OnePasswordField $field): OnePasswordItem
    {
        $this->fields->add($field);
        return $this;
    }

    public function setFields(OnePasswordFieldCollection $fields): OnePasswordItem
    {
        $this->fields = $fields;
        return $this;
    }
}
