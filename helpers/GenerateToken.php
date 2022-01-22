<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\helpers;

abstract class GenerateToken
{
    public static $seed;
    public static $time;
    public static $hash;

    public static function CreateToken()
    {
        self::$seed = random_bytes(8);
        self::$time = time();
        self::$hash = hash_hmac('sha256', session_id() . self::$seed . self::$time, CSRF_TOKEN_SECRET, true);
        return self::UrlSafeEncode(self::$hash . '|' . self::$seed . '|' . self::$time);
    }

    public static function ValidateToken($token)
    {
        $parts = explode('|', self::UrlSafeDecode($token));
        if(count($parts) == 3){
            $hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2],CSRF_TOKEN_SECRET, true);
            if(hash_equals($hash, $parts[0])) {
                return true;
            }
        }
        return false;
    }

    public static function UrlSafeEncode($m)
    {
        return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
    }

    public static function UrlSafeDecode($m)
    {
        return base64_decode(strtr($m, '-_', '+/'));
    }

}
