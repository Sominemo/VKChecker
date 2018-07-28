<?php

class VKDevHealth implements Checker {

    private static $data = [];
    private static $result = false;
    private static $about = false;

    public static function work() {

    }

    private static function getData() {
        $r = Network::Request('https://vk.com/dev/health');
        preg_match('/var content = {\n +\'data\': (.+),.+header.+};\nhealthTable/is', $r, $t);
        $t = json_decode($t[1]);
        $m = [];
        foreach ($t as $v) {
            $m[] = [$v[0], $v[3]];
        }
        self::$data = $m;
        return $m;
    }

    private static function generate() {
        
    }

    public static function result() {
    }

    public static function about() {

    }
}