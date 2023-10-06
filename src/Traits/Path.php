<?php

namespace Aybarsm\Whmcs\Service\Traits;

trait Path
{
    protected static function providePath(string $topLevel, string $additional = ''): string
    {
        return static::normalisePath($topLevel) . static::normalisePath($additional);
    }
    protected static function normalisePath(string $path): string
    {
        if (empty($path)){
            return $path;
        }
        $dirSep = DIRECTORY_SEPARATOR;

        return $dirSep . trim(str_replace(['\\', '/'], $dirSep, $path), "{$dirSep} ");
    }

    public static function getRootPath(string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Config\Application::class)->getRootDir();

        return static::providePath($pathBase, $path);
    }

    public static function getModulesPath(string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Module\Autoloader::class)->getBaseModulePath();

        return static::providePath($pathBase, $path);
    }

    public static function getAddonsPath(string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Module\Addon::class)->getBaseModuleDir();

        return static::providePath($pathBase, $path);
    }

    public static function getGatewaysPath(string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Module\Gateway::class)->getBaseModuleDir();

        return static::providePath($pathBase, $path);
    }

    public static function getGatewayPath(string $name, string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Module\Gateway::class)->getModuleDirectory($name);

        return static::providePath($pathBase, $path);
    }

    public static function getAddonPath(string $name, string $path = ''): string
    {
        $pathBase = static::getInstance(\WHMCS\Module\Addon::class)->getModuleDirectory($name);

        return static::providePath($pathBase, $path);
    }
}