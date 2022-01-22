<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\helpers;

abstract class Http
{
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isGet()
    {
        return self::method() === 'GET';
    }

    public static function isPost()
    {
        return self::method() === 'POST';
    }

    public static function getBody()
    {
        $data = [];

        if (self::isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if (self::isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $data;
    }

    public static function Redirect($url)
    {
        header("Location: $url");
    }

}
