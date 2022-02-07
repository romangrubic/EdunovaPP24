<?php

// We want to see all warnings and errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Session
session_start();

// Base path configuration
define('BP', __DIR__ . DIRECTORY_SEPARATOR);
define('BP_APP', __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);

// Route where we can access our PHP classes
$putanje = implode(PATH_SEPARATOR, [
    BP_APP . 'model',
    BP_APP . 'controller',
    BP_APP . 'core'
]);

// Include our routes
set_include_path($putanje);

// Autoload register
spl_autoload_register(function ($klasa) {
    $putanje = explode(PATH_SEPARATOR, get_include_path());
    foreach ($putanje as $p) {
        $datoteka = $p . DIRECTORY_SEPARATOR . $klasa . '.php';
        if (file_exists($datoteka)) {
            include_once $datoteka;
            break;
        }
    }
});

App::start();
