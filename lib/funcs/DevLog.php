<?php

class DevLog {
    static private $log = [];

    public static function w($d) {
        if (EGV::Get('DEV_MODE')) {
        static::$log[] = $d;
        file_put_contents('liblog.log', print_r(static::$log, true));
        }
    }

    public static function g() {
        return static::$log;
    }
}