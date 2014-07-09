<?php

require __DIR__.'/bootstrap.php';

chdir(__DIR__);

foreach (glob('*Test.php') as $filename) {
    echo "\n";
    echo basename($filename, 'Test.php')."\n";
    echo str_repeat('=', strlen(basename($filename, 'Test.php')))."\n";
    echo "\n";
    require $filename;
}

