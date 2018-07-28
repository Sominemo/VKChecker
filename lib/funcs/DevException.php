<?php

class DevException extends Exception {
    public function __construct($m, $c = 0)
    {
        if (!EGV::Get('DEV_MODE')) return true;
        else 
        echo "#$c: <b>$m</b><br>";
    }
}