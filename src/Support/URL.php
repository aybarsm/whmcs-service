<?php

declare(strict_types=1);

namespace Aybarsm\Whmcs\Service\Support;
use Aybarsm\Whmcs\Service\Whmcs;
class URL
{
    protected static function resolve(string|\Stringable $baseUrl, string|\Stringable ...$parts): string
    {
        $parts = array_map(static fn ($part) => trim(trim(trim((string) $part))), $parts);
        $baseUrl = trim(trim(trim($baseUrl), '/'));
        array_unshift($parts, $baseUrl);
        return implode('/', $parts);
    }

    public static function systemUrl(string|\Stringable ...$parts): string
    {
        return static::resolve(Whmcs::getSystemUrl(), ...$parts);
    }

    public static function systemDomainUrl(string|\Stringable ...$parts): string
    {
        return static::resolve(\WHMCS\Config\Setting::getValue('Domain'), ...$parts);
    }
}