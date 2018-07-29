<?php

class DevException extends Exception {
    public function __construct($m, $c = 0)
    {
        $s = "#$c: <b>$m</b><br>";

        DevLog::w($s);

        if (!EGV::Get('DEV_MODE')) return true;
        else 
        echo $s;
    }
}