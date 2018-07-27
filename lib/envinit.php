<?php

spl_autoload_register(function ($a) {
    include_once 'funcs/' . $a . '.php';
});

