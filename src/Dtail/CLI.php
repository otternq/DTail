<?php

namespace DTail;

include "vendor/autoload.php";

use Colors\Color;

class CLI {

    protected static $levels = array(
        100 => 'DEBUG',
        200 => 'INFO',
        250 => 'NOTICE',
        300 => 'WARNING',
        400 => 'ERROR',
        500 => 'CRITICAL',
        550 => 'ALERT',
        600 => 'EMERGENCY',
    );

    const formatString = "%-17s %-11.10s %-10s %-60s %s\n";

    static function run($iterator) {

        foreach($iterator as $item) {

            echo self::color(
                self::format($item),
                $item['level']['N']
            );

        }

    }

    static function format($item) {

        return sprintf(
            self::formatString, 
            $item['channel']['S'], 
            $item['datetime']['S'],
            $item['level_name']['S'], 
            $item['message']['S'], 
            $item['context']['S']
        );

    }

    static function color($string, $level) {

        $c = new Color();

        $out = new $c($string);
            
        switch ($level) {
            //250 is notice
            case 300: //warning
                $out = $out->yellow;
            break;
            case 400:
                $out = $out->red;
            break;
        }

        return $out;
    }

}