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
}
