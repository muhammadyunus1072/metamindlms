<?php

namespace App\Helpers;

class EncryptionHelper
{
    public static function encrypt($string)
    {
        $key = env("APP_KEY", "");
        $algo = "AES-128-CBC";
        $ivKey = substr(env("APP_KEY", ""), 9, 16);
        $options = 0;

        return openssl_encrypt($string, $algo, $key, $options, $ivKey);
    }

    public static function decrypt($encryptedString)
    {
        $key = env("APP_KEY", "");
        $algo = "AES-128-CBC";
        $ivKey = substr(env("APP_KEY", ""), 9, 16);
        $options = 0;

        return openssl_decrypt($encryptedString, $algo, $key, $options, $ivKey);
    }
}
