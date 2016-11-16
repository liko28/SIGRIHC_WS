<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 16/11/16
 * Time: 10:46 AM
 */

namespace Helpers;


class CustomArray extends \ArrayObject implements \ArrayAccess {
    public function commaSep() {
        return implode(',',$this->getArrayCopy());
    }

    public function values() {
        return array_values($this->getArrayCopy());
    }
}