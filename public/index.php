<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_exception_handler(function($e) {
    echo "<pre>Exception attrapée: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
});

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Routeur/Routeur.php';
