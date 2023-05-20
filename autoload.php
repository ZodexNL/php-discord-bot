<?php

// Automaticly include all files
spl_autoload_register(function ($classname) {

    $baseDir = __DIR__ . '/src';

    $classname = str_replace('\\', '/', $classname);

    $file = $baseDir . '/' . $classname . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
