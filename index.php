<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

const CONFIG_PATH = 'config/routing.yml';

$klein = new \Klein\Klein();

$routeConfig = Yaml::parse(file_get_contents(CONFIG_PATH));

foreach ($routeConfig['routes'] as $currentConfig) {
    $class = new $currentConfig['class'];

    $reflectionMethod = new ReflectionMethod($currentConfig['class'], $currentConfig['function']);

    $klein->respond($currentConfig['method'], $currentConfig['path'], $reflectionMethod->getClosure(new $currentConfig['class']));
}

$klein->dispatch();
