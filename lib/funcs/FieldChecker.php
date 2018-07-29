<?

class FieldChecker {
    private $rules = false;
    private $data = false;

    public function __construct($r)
    {
        if (!is_array($r)) return false;
        $this->rules = $r;
        return true;
    }

    public function set($q) {
        $e = $this->strCheck($q);
        if (!$e) {
            throw new DevException("Incorrect data: FieldChecker doesn't passed", 5);
            return false;
        }
        $this->data = $q;
        return true;
    }

    public function get() {
        return $this->data;
    }

    public function getRules() {
        return $this->rules;
    }

    private function strCheck($q) {
        $q = (string) $q;
        $o = $this->rules;
        if (!is_array($o) || !is_string($q)) return false;

        $p = [];
        $p['length'] = strlen($q);

        // MIN Length
        if (isset($o['min'])) {
            if ($p['length'] < $o['min']) return false;
        }

        // MAX Length
        if (isset($o['max'])) {
            if ($p['length'] > $o['max']) return false;
        }

        // RegExp
        if (isset($o['regex'])) {
            if (!preg_match($o['regex'], $q)) return false;
        }

        // Symbols
        if (isset($o['symbols'])) {
            $slq = preg_quote($o['symbols']);
            if (!preg_match('/([{$slq}]+)?/', $q)) return false;
        }

        // Numeric
        if (isset($o['numeric']) && $o['numeric'] == true) {
            if (!is_numeric($q)) return false;
        }

        // IntRange
        if (isset($o['range']) && is_numeric($q)) {
            if (is_numeric($o['range'][0]) && is_numeric($o['range'][1])) {
                $o['range'][0] = $o['range'][0]+0;
                $o['range'][1] = $o['range'][1]+0;
                if ($q < $o['range'][0] || $q > $o['range'][1]) return false;
            } 
        }

        return true;
    }
}