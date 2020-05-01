<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

const CONFIG_PATH = 'config/routing.yml';

$klein = new \Klein\Klein();

$routeConfig = Yaml::parse(file_get_contents(CONFIG_PATH));

foreach ($routeConfig['routes'] as $currentConfig) {
    $reflectionClass  = new ReflectionClass($currentConfig['class']);
    $reflectionMethod = $reflectionClass->getMethod($currentConfig['function']);

    $arguments = [];

    foreach ($currentConfig['dependency'] ?? [] as $dependency) {
        $arguments[] = new $dependency;
    }

    $klein->respond(
        $currentConfig['method'],
        $currentConfig['path'],
        $reflectionMethod->getClosure($reflectionClass->newInstanceArgs($arguments))
    );
}

$klein->dispatch();
