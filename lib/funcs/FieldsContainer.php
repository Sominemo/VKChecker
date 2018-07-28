<?php

class FieldsContainer {
    private $data = false;
    private $type = false;

    public function __construct($a) {
        if (is_array($a)) $this->type = $a;
        else if (is_string($a) && isset(self::PREDEF_TYPES[$a])) $this->type = self::PREDEF_TYPES[$a];

        if (!is_array($this->type) || !isset($this->type[0]) || !isset($this->type[1])) $this->type = false;
        return $this->type;
    }

    public function set($a) {
        if (!is_array($a)) {throw new DevException("Incorrect data: Not array", 5); return false;}

        $tr = $this->type;
        if (!$tr) {throw new DevException("Incorrect data: Incorrect rule", 5); return false;}

        if ($tr[0] === "array") {
            $tr[0] = range(0, count($a)-1);
            $tr[1] = array_fill(0, count($a), $tr[1]);
            if (EGV::Get("DEV_MODE")) echo "<b>Compiled rule:</b> ".print_r($tr, true)."<br>";
        }

        $e = [];

        foreach ($tr[0] as $v) {
            if (!isset($a[$v])) {throw new DevException("Incorrect data: Field is not set", 5); return false;}
            if (array_key_exists($v, $tr[1])) {
                $y = new FieldsContainer($tr[1][$v]);
                try {
                    $y->set($a[$v]);
                 } catch (DevException $e) {throw new DevException("Incorrect data: Incorrect child check", 5); return false;}
            }
            $e[$v] = $a[$v];
        }

        $this->data = $e;

        return true;
    }

    public function get() {
        return $this->data;
    }

    public function getType() {
        return $this->type;
    }

    const PREDEF_TYPES = [
        "CheckerAbout" => [['name', 'about', 'id', 'dev'], []],
        "CheckerResult" => [['main', 'details', 'info'], ['details' => ["array", "CheckerInstance"]]],
        "CheckerInstance" => [['status', 'name', 'index'], []]
    ];
}