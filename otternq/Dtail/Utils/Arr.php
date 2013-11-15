<?php

namespace DTail\Utils;

class Arr {

    private $arr;

    public function __construct($arr) {
        if (!is_array($arr)) {
            throw new \Exception('$arr is not an array');
        }

        $this->arr = $arr;

    }

    public function get($index, $throw = false) {
        if (isset($this->arr[$index])) {
            return $this->arr[$index];
        }

        if ($throw == false) {
            return false;
        } else {
            throw new \Exception('$arr has no element with index: '. $index);
        }
    }

}