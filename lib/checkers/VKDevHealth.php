<?php

class VKDevHealth implements Checker {

    private static $data = [];
    private static $results = false;
    private static $about = [
        "name" => "checker_VKDevHealth_name",
        "about" => "checker_VKDevHealth_about",
        "dev" => "Sergey Dilong"
    ];

    public static function getAbout() {
        return self::$about;
    }

    public static function work() {
        self::getData();
        self::$results = self::generate();
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
        $r = self::getGeneralStatus(self::analyzeInstances(self::$data));
        $c = new FieldsContainer("CheckerResult");
        $c->set($r);

        return $r;
    }

    private static function analyzeInstances($d) {
        $c = new FieldsContainer(["array", [["0", "1"], []]]);
        $c->set($d);

        $r = [];

        foreach ($d as $v) {
            if ($v[1] == 100) $s = 1;
            else if ($v[1] > 30) $s = 2;
            else $s = 3;

            $r[] = [
                'status' => $s,
                'name' => $v[0],
                'index' => $v[1]
            ];
        };

        return $r;
    }

    private static function getGeneralStatus($d) {
        $c = new FieldsContainer(["array", "CheckerInstance"]);
        $c->set($d);

        $w = 0;

        foreach ($d as $v) {
            if ($v['status'] > $w) $w = $v['status'];
        }
        
        $i = __("checker_VKDevHealth_st_$w");

        return [
            "main" => $w,
            "info" => $i,
            "details" => $d
        ];
    }

    public static function result() {
        return self::$results;
    }
}