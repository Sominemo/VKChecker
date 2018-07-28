<?php

require_once("user_set.php");

spl_autoload_register(function ($a) {
    include_once 'funcs/' . $a . '.php';
});

Language::Set();

Checkers::AddNew('VKDevHealth');

VKDevHealth::work();

echo __("hello");