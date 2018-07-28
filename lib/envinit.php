<?php

require_once("user_set.php");

spl_autoload_register(function ($a) {
    include_once 'funcs/' . $a . '.php';
});

Language::Set();

Checkers::AddNew('VKDevHealth');

VKDevHealth::work();

$r = new FieldsContainer(["array", "CheckerInstance"]);
$r->set([
    [
        "status" => 1,
        "name" => "Wow",
        "index" => "100"
    ],
    [
        "status" => 1,
        "name" => "Wow",
        "index" => "100"
    ]
]);

$r->get();