<?php

set_exception_handler(function($e) {
    if ($e instanceof DevException) {
        if (EGV::Get('DEV_MODE')) echo $e->getM();
        DevLog::w("Unhandled DevException | ".$e->getM());
    }
});

class DevException extends Exception {
    private $s;
    public function __construct($m, $c = 0)
    {
        $s = "#$c: <b>$m</b><br>";

        DevLog::w("Called DevException | ".$s);
    }

    public function getM() {
        return $this->s;
    }
}