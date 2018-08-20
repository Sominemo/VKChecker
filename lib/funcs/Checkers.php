<?php

class Checkers
{
    private static $reg = [];

    public static function AddNew($name)
    {
        include_once 'checkers/' . $name . '.php';

        if (!new $name instanceof Checker) {
            throw new Exception("Incorrect Checker", 4);
        }

        $reg[] = new $name;
    }

    public static function About($q)
    {
        $m = $q::getAbout();
        $r = [
            "name" => __($m['name']),
            "about" => __($m['about']),
            "id" => $q,
            "dev" => $m['dev'],
        ];
        $c = new FieldsContainer("CheckerAbout");
        $c->set($r);
        return $r;
    }

    public static function Get($q) {
        $q::work();
        $m = $q::result();

        $c = new FieldsContainer("CheckerResult");
        $c->set($m);
        return $m;
    }

    public static function GetGeneralized($q) {
        if (!$q::IsInited()) $q::work();
        $a = $q::result();
        $all = count($a['details']);
        $passed = 0;
        foreach ($a['details'] as $v) {
            if ($v['status'] === 0) $passed++;
        }
        $r = [
            "main" => $a["main"],
            "all_instances" => $all,
            "passed" => $passed
        ];

        $e = new FieldsContainer("CheckerGeneral");
        $e->set($r);
        return $e->get();
    }

    public static function getCheckersIds() {
        return self::$reg;
    }

    public static function getErrorCheckerResult() {
        return [
            "main" => 1,
            "details" => [1, "???", "?"],
            "info" => __("checker_incorrect_data")
        ];
    }

    public static function getErrorCheckerAbout($q) {
        return [
            "name" => "???",
            "about" => __("checker_incorrect_info"),
            "id" => $q,
            "dev" => "Unknown"
        ];
    }

    public static function getGeneralStatus() {
        $r = self::$reg;
        $m = [];
        
        foreach ($r as $v) {
            try {
                $e = self::Get($v);
            } catch (DevException $rr) {

            } catch (Exception $pr) {

            }

        }
    }
}
