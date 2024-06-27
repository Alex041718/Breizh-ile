<?php
spl_autoload_register(function ($class) {
    // Directories to search for classes
    $dirs = [
        __DIR__ . '/dompdf/src/',
        __DIR__ . '/dompdf/lib/',
        __DIR__ . '/html5-php/src/'
    ];

    foreach ($dirs as $baseDir) {
        // Determine the correct prefix length
        $len = strlen('Dompdf\\');
        $html5Len = strlen('Masterminds\\');

        if (strncmp('Dompdf\\', $class, $len) === 0) {
            // Get the relative class name
            $relativeClass = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        } elseif (strncmp('Masterminds\\', $class, $html5Len) === 0) {
            // Get the relative class name
            $relativeClass = substr($class, $html5Len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        } else {
            // No, move to the next directory
            continue;
        }

        // If the file exists, require it
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
});
