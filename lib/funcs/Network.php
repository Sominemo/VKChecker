<?

class Network {
    public static function Request($a, $o = []) {
        $r = file_get_contents($a);
        if ($r === false) throw new Exception(self::MESSAGES["ERROR_REQ_RES"], self::CODES["ERROR_REQ_RES"]);

        $rd = $r;

        if ($o["AS_JSON"]) {
            $j = json_decode($r);
            if (json_last_error() !== JSON_ERROR_NONE) throw new Exception(self::MESSAGES["JSON_PARSE_ERR"], self::CODES["JSON_PARSE_ERR"]);
            $rd = $j;
        } 

        return $rd;
    }

    const CODES = [
        "ERROR_REQ_RES" => 100,
        "JSON_PARSE_ERR" => 101
    ];

    const MESSAGES = [
        "ERROR_REQ_RES" => "Error Processing Request",
        "JSON_PARSE_ERR" => "Error Parsing JSON"
    ];
}