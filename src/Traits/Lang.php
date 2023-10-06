<?php

namespace Aybarsm\Whmcs\Service\Traits;

use Illuminate\Support\Arr;

trait Lang
{
    public static function addAdminLangResource(string $path, string $language): void
    {
        if (in_array($path, Arr::get(static::$init, "lang.admin.{$language}", []))){
            return;
        }

        $instance = static::getInstance(\WHMCS\Language\AdminLanguage::class);
        $instance::factory()->addResource('whmcs', $path, $language);

        Arr::set(static::$init, "lang.admin.{$language}", array_merge(Arr::get(static::$init, "lang.admin.{$language}", []), Arr::wrap($path)));
    }
}