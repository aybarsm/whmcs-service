<?php

namespace Aybarsm\Whmcs\Service\Abstracts;

use Aybarsm\Whmcs\Service\Contracts\WhmcsInterface;

abstract class AbstractWhmcs implements WhmcsInterface
{
    protected static array $init = [];

    abstract protected static function providePath(string $topLevel, string $additional = ''): string;
    abstract protected static function normalisePath(string $path): string;

}