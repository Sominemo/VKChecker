<?php

class Checkers {
    protected static $reg = [];

    public static function AddNew($name) {
            include_once('checkers/'.$name.'.php');

            if (!new $name instanceof Checker) throw new Exception("Incorrect Checker", 4);
            
            $reg[] = new $name;
    }
}