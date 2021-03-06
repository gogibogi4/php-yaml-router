<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

const CONFIG_PATH = 'config/routing.yml';

$loadedDependencies = [];

$klein = new \Klein\Klein();

$routeConfig = Yaml::parse(file_get_contents(CONFIG_PATH));

foreach ($routeConfig['routes'] as $currentConfig) {
    validateClass($currentConfig['class']);
    validateMethod($currentConfig['class'], $currentConfig['function']);

    $reflectionClass  = new ReflectionClass($currentConfig['class']);
    $reflectionMethod = $reflectionClass->getMethod($currentConfig['function']);

    $klein->respond(
        $currentConfig['method'],
        $currentConfig['path'],
        $reflectionMethod->getClosure(
            $reflectionClass->newInstanceArgs(constructArguments($currentConfig['dependency'] ?? [], $loadedDependencies))
        )
    );
}

$klein->dispatch();

/**
 * @param array $dependencies
 * @param array $loadedDependencies
 * @return array
 */
function constructArguments(array $dependencies, array &$loadedDependencies): array
{
    $arguments = [];

    foreach ($dependencies as $dependency) {
        validateClass($dependency);

        if (!isset($loadedDependencies[$dependency])) {
            $loadedDependencies[$dependency] = new $dependency;
        }

        $arguments[] = $loadedDependencies[$dependency];
    }

    return $arguments;
}

/**
 * @param string $className
 */
function validateClass(string $className): void
{
    if (!class_exists($className)) {
        throw new RuntimeException(sprintf('Class %s does not exist!', $className));
    }
}

/**
 * @param string $className
 * @param string $methodName
 */
function validateMethod(string $className, string $methodName): void
{
    $class = (new ReflectionClass($className))->newInstanceWithoutConstructor();

    if (!method_exists($class, $methodName)) {
        throw new RuntimeException(sprintf('Method %s does not exist!', $methodName));
    }
}