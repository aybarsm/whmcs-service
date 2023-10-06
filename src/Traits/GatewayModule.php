<?php

namespace Aybarsm\Whmcs\Service\Traits;

trait GatewayModule
{
    public static function isGatewayActive(string $gateway): bool
    {
        return static::getInstance(\WHMCS\Module\Gateway::class)->isActiveGateway($gateway);
    }

    public static function getGatewaySettingValue(string $gateway, string $setting)
    {
        return \WHMCS\Module\GatewaySetting::getValue($gateway, $setting);
    }

    public static function getGatewaySettings(string $gateway): array
    {
        return \WHMCS\Module\GatewaySetting::getForGateway($gateway);
    }
}