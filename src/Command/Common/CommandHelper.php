<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command\Common;

class CommandHelper
{
    /**
     * @param array<string, string|bool> $options
     * @return string[]
     */
    public function processOptionsToCommandArray(array $options): array
    {
        $command = [];
        foreach ($options as $option => $value) {
            if ($value === false) {
                continue;
            }

            $command[] = $option;
            if (!is_bool($value)) {
                $command[] = (string) $value;
            }
        }

        return $command;
    }
}
