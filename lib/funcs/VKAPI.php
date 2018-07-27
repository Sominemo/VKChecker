<?php

class VKAPI {
    
    const DOMAIN = "https://api.vk.com/method/";
    const VERSION = "5.80";
    const TOKEN = EGV::VK_TOKEN;

    static function callable() {
        if (!preg_match("^[0-9a-f]+$", self::TOKEN))
        throw new Exception("Token is unset", 1);
        
    }

    static function __call($name, $arguments)
    {
        
    }
}