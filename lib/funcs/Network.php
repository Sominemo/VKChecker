<?

class Network {
    public static function Request($a, $o = []) {
        $postdata = http_build_query((length($o['POST']) > 0 ? $o['POST'] : []));

        $opts = ['http' =>
                    [
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $postdata
                    ]
                ];

        $context  = stream_context_create($opts);
        $r = file_get_contents($a, false, $context);
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
