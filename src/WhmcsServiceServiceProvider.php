<?php

namespace Aybarsm\Whmcs\Service;
use WHMCS\Application\Support\ServiceProvider\AbstractServiceProvider;

class WhmcsServiceServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WhmcsService::class, WhmcsService::class);
        $this->app->alias(WhmcsService::class, 'service');
    }
}