<?php

namespace Aybarsm\Whmcs\Service;

use Aybarsm\Whmcs\Service\Abstracts\AbstractWhmcs;
use Aybarsm\Whmcs\Service\Contracts\WhmcsInterface;
use Aybarsm\Whmcs\Service\Traits\GatewayModule;
use Aybarsm\Whmcs\Service\Traits\Invoice;
use Aybarsm\Whmcs\Service\Traits\Lang;
use Aybarsm\Whmcs\Service\Traits\Macros;
use Aybarsm\Whmcs\Service\Traits\Path;
use Aybarsm\Whmcs\Service\Traits\Security;
use Aybarsm\Whmcs\Service\Traits\Transaction;
use WHMCS\Application\Support\Facades\App;

class Whmcs extends AbstractWhmcs implements WhmcsInterface
{
    use Path, Invoice, GatewayModule, Transaction, Security, Macros, Lang;

    public static function getContainer(): \WHMCS\Container
    {
        return \WHMCS\Application\Support\Facades\Di::getFacadeApplication();
    }

    public static function getApp(): \WHMCS\Application
    {
        return static::getContainer()->get('app');
    }

    public static function getInstance(string $instance)
    {
        return static::getContainer()->get($instance);
    }

    public static function getSystemUrl(): string
    {
        return App::isSSLAvailable() ? App::getSystemSSLURL(false) : App::getSystemURL(false);
    }

    public static function redirect($path = null, $vars = null, $prefix = null): void
    {
        static::getApp()->redirect($path, $vars, $prefix);
    }

    public static function redirectSystemUrl(): void
    {
        // WHMCS's redirectSystemURL functionality causing 302 loops.
        // This is the safest and most built-in way.
        static::redirectTo(static::getSystemUrl());
    }

    public static function redirectTo(string $url): void
    {
        header("Location: {$url}");
        exit();
    }



}