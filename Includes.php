<?php

// Include all files in the 'src' directory

$srcDir = 'src/';

function includeFiles($dir)
{
    $files = glob($dir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            include $file;
        } elseif (is_dir($file)) {
            includeFiles($file);
        }
    }
}

includeFiles($srcDir);
