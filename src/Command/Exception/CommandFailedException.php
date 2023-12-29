<?php

declare(strict_types=1);

namespace Nuonic\OnePasswordCli\Command\Exception;

use Symfony\Component\Process\Exception\ProcessFailedException;

class CommandFailedException extends ProcessFailedException
{
}
