<?php

namespace Aybarsm\Whmcs\Service\Contracts;

interface WhmcsInterface
{
    public static function getContainer(): \WHMCS\Container;
    public static function getApp(): \WHMCS\Application;
    public static function getInstance(string $instance);
    public static function getSystemUrl(): string;
    public static function redirect($path = null, $vars = null, $prefix = null): void;
    public static function redirectSystemUrl(): void;
    public static function redirectTo(string $url): void;
    public static function getRootPath(string $path = ''): string;
    public static function getModulesPath(string $path = ''): string;
    public static function getAddonsPath(string $path = ''): string;
    public static function getGatewaysPath(string $path = ''): string;
    public static function getGatewayPath(string $name, string $path = ''): string;
    public static function getAddonPath(string $name, string $path = ''): string;
    public static function getInvoiceById(int $id): ?\WHMCS\Billing\Invoice;
    public static function isGatewayActive(string $gateway): bool;
    public static function getGatewaySettingValue(string $gateway, string $setting);
    public static function getGatewaySettings(string $gateway): array;

    public static function newTransactionHistory(array $attributes): \WHMCS\Billing\Payment\Transaction\History;
    public static function encryptPassword($value): ?string;
    public static function decryptPassword($value): ?string;
    public static function getAesInstance(): \WHMCS\Security\Encryption\Aes;
    public static function aesEncrypt($value): string;
    public static function aesDecrypt($value): string;
    public static function registerMacros(): void;
    public static function addAdminLangResource(string $path, string $language): void;
}