<?php

namespace SIGRI_HC\Helpers;


abstract class Generic
{
    public static function findAnswer($needle, array $haystack){
        foreach ($haystack as $item) {
            if ($item[0] == $needle) {
                return $item;
            }
        }
    }
}