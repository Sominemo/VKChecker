<?php

class DevLog {
    static private $log = [];

    public static function w($d) {
        if (EGV::Get('DEV_MODE'))
        static::$log[] = $d;
    }

    public static function g() {
        return static::$log;
    }
}