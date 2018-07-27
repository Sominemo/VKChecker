<?php

class __VKAPI_DATA {
    const DOMAIN = "https://api.vk.com/method/";
    const VERSION = "5.80";
    const TOKEN = EGV::VK_TOKEN;
}

class VKAPI extends __VKAPI_DATA {

    static function callable() {
        if (!preg_match("^[0-9a-f]+$", self::TOKEN))
        throw new Exception("Token is unset", 1);
        
    }

    static function __call($name, $arguments)
    {
        return __VKAPI_METHOD_HANDLER($name, $arguments);
    }
}

class __VKAPI_METHOD_HANDLER extends __VKAPI_DATA {
    static function __call($name, $arguments)
    {
        $l = self::DOMAIN.$arguments[0].".".$name;
        $s = $arguments[1];
        if (!isset($s['access_token'])) $s['access_token'] = self::TOKEN;
        if (!isset($s['v'])) $s['v'] = self::VERSION;
        $t = Network::Request($l, ['AS_JSON' => true, 'POST' => $s]);
        return $t;
    }
}