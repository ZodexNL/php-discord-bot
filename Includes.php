<?php

// Include all files in the 'src' directory

$srcDir = 'src/';
$allFolders = array_diff(scandir($srcDir), array('..', '.'));

foreach ($allFolders as $folder) {
    foreach (glob($srcDir . $folder . '/*.php') as $file) {
        include $file;
    }
}
