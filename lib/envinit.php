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
        "status" => 0,
        "name" => "Wow",
        "index" => "100"
    ],
    [
        "status" => 3,
        "name" => "Wow",
        "index" => "100"
    ]
]);


print_r($r->get());

//$r = new FieldChecker(['numeric' => true, 'range' => [0, 3]]);
//$r->set(1);