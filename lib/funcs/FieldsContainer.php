<?php

class FieldsContainer {
    private $data = false;
    private $type = false;

    public function __construct($a) {
        if (is_array($this->type)) $this->type = $a;
        else if (is_string($a) && isset($this->PREDEF_TYPES[$a]))  $this->type = $this->PREDEF_TYPES[$a];

        if (!is_array($this->type) || isset($this->type[0]) || isset($this->type[1])) $this->type = false;
        return $this->type;
    }

    public function set($a) {
        if (!is_array($a)) return false;

        $tr = $this->type;
        if (!$tr) return false;

        if ($tr[0] === "array") {
            $tr[0] = range(0, count($a)-1);
            $tr[1] = array_fill(0, count($a)-1, $tr[1]);
        }

        $e = [];

        foreach ($tr[0] as $v) {
            if (!isset($a[$v])) return false;
            if (array_key_exists($v, $tr[1])) {
                $y = new FieldsContainer($tr[1][$v]);
                if (!$y->set($a[$v])) return false;
            }
            $e[$v] = $a[$v];
        }

        $this->data = $e;

        return true;
    }

    const PREDEF_TYPES = [
        "CheckerAbout" => [['name', 'about', 'id', 'dev'], []],
        "CheckerResult" => [['main', 'details', 'info'], ['details' => self::PREDEF_TYPES['CheckerInstances']]],
        "CheckerInstances" => ["array", "CheckerInstance"],
        "CheckerInstance" => [['status', 'name', 'index'], []]
    ];
}