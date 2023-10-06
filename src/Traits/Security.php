<?php

namespace Aybarsm\Whmcs\Service\Traits;

trait Security
{
    public static function encryptPassword($value): ?string
    {
        $data = localAPI('EncryptPassword', ['password2' => $value]);
        return $data['result'] == 'success' ? $data['password'] : null;
    }

    public static function decryptPassword($value): ?string
    {
        $data = localAPI('DecryptPassword', ['password2' => $value]);
        return $data['result'] == 'success' ? $data['password'] : null;
    }

    public static function getAesInstance(): \WHMCS\Security\Encryption\Aes
    {
        return static::getInstance(\WHMCS\Security\Encryption\Aes::class);
    }

    public static function aesEncrypt($value): string
    {
        return static::getAesInstance()->encrypt($value);
    }

    public static function aesDecrypt($value): string
    {
        return static::getAesInstance()->decrypt($value);
    }
}