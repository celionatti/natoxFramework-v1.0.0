<?php

declare(strict_types=1);

/**User: Celio Natti *** */

namespace natoxCore\helpers;

abstract class Pagination
{
    private static $data;

    public static function Paginate($values, $per_page)
    {
        $total_values = count($values);

        if (isset($_GET['page'])) {
            $current_page = $_GET['page'];
        } else {
            $current_page = 1;
        }
        $counts = ceil($total_values / $per_page);

        $param = ($current_page - 1) * $per_page;
        self::$data = array_slice($values, $param, $per_page);

        for ($x = 1; $x <= $counts; $x++) {
            $numbers[] = $x;
        }
        return $numbers;
    }

    public static function GetPaginate()
    {
        $resultsValue = self::$data;
        echo $resultsValue;
    }
}
