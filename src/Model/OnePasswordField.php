<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Model;

class OnePasswordField
{
    public string $id;
    public string $type;
    public string $label;
    public string $value;
    public OnePasswordItemRef $reference;

    public function setReference(string $reference): OnePasswordField
    {
        $this->reference = new OnePasswordItemRef($reference);
        return $this;
    }
}
