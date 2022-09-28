<?php

namespace Core\Routing;

class Route
{
    public const POST   = 'POST';
    public const PUT    = 'PUT';
    public const GET    = 'GET';

    public string $controller;

    public string $action;

    private static array $routes = [];

    public static function post(string $uri, $controller, $action): void
    {
        self::$routes[self::POST][$uri] = [
            'controller'    => $controller,
            'action'        => $action
        ];
    }

    public static function get(string $uri, $controller, $action): void
    {
        self::$routes[self::GET][$uri] = [
            'controller'    => $controller,
            'action'        => $action
        ];
    }

    public static function put(string $uri, $controller, $action): void
    {
        self::$routes[self::PUT][$uri] = [
            'controller'    => $controller,
            'action'        => $action
        ];
    }

    public static function routes(): array
    {
        return self::$routes;
    }

    public static function exists(string $method, $uri): bool
    {
        return isset(self::$routes[$method][$uri]);
    }

    public static function parse($method, $uri) : self
    {
        $route = self::$routes[$method][$uri];

        $instance = new self();
        $instance->controller   = $route['controller'];
        $instance->action       = $route['action'];

        return $instance;
    }
}