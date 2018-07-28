<?php

class __VKAPI_DATA {
    private const DOMAIN = "https://api.vk.com/method/";
    private const VERSION = "5.80";
    private const TOKEN = EGV::VK_TOKEN;
}

class VKAPI extends __VKAPI_DATA {

    static function callable() {
        if (!preg_match("^[0-9a-f]+$", self::TOKEN))
        throw new Exception("Token is unset", 1);
        
    }

    static function call($name, $s)
    {
        $l = self::DOMAIN.$name;
        if (!is_array($s)) return false;
        if (!isset($s['access_token'])) $s['access_token'] = self::TOKEN;
        if (!isset($s['v'])) $s['v'] = self::VERSION;
        $t = Network::Request($l, ['AS_JSON' => true, 'POST' => $s]);
        return $t;
    }
}