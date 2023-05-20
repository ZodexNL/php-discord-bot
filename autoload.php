<?php

// Automaticly include all files
spl_autoload_register(function ($classname) {

    $file = $classname = str_replace('\\', '/', $classname) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
