<?php

spl_autoload_register(function($name) {
    $include = $name;

    if (strpos($name, "\\")) {
        $include = str_replace("\\", "/", $include);
    }

    include $include . ".php";
});
