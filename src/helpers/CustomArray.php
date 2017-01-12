<?php

namespace SIGRI_HC\Helpers;

class CustomArray extends \ArrayObject implements \ArrayAccess {
    /** @return string */
    public function commaSep() {
        return implode(',',$this->getArrayCopy());
    }

    /** @return array */
    public function values() {
        return array_values($this->getArrayCopy());
    }
}