<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 15/11/16
 * Time: 04:52 PM
 */

namespace Helpers;


class Row {
    public function __construct(array $row) {
        foreach ($row as $field => $value) {
            $this->$field = $value;
        }
    }
}