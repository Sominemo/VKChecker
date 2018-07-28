<?php

interface __VKAPI_DATA {
    const DOMAIN = "https://api.vk.com/method/";
    const VERSION = "5.80";
}

class VKAPI implements __VKAPI_DATA {

    static function TOKEN() {
        return EGV::Get('VK_TOKEN');
    }

    static function callable() {
        if (!preg_match("/^[0-9a-f]+$/", self::TOKEN()))
        throw new Exception("Token is unset", 1);
    }

    static function call($name, $s = [])
    {
        self::callable();
        
        $l = self::DOMAIN.$name;
        if (!is_array($s)) return false;
        if (!isset($s['access_token'])) $s['access_token'] = self::TOKEN();
        if (!isset($s['v'])) $s['v'] = self::VERSION;
        $t = Network::Request($l, ['AS_JSON' => true, 'POST' => $s]);
        return $t;
    }
}