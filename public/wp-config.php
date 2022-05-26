<?php

require __DIR__ . '/../vendor/autoload.php';

if (class_exists('\Whoops\Run')) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

$application = new WordPlate\Application(realpath(__DIR__ . '/../'));
$application->run();

$table_prefix = env('DB_TABLE_PREFIX', 'wp_');

require_once ABSPATH . 'wp-settings.php';
