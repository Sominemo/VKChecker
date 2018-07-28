<?php

require_once("user_set.php");

spl_autoload_register(function ($a) {
    include_once 'funcs/' . $a . '.php';
});

VKAPI::call('users.get');

Checkers::AddNew('VKDevHealth');

VKDevHealth::work();