<?php

namespace Core\Routing;

use Core\Request;

class Router
{
    private string $uri;

    private string $method;

    private array $payload = [];

    private Route $route;

    private mixed $controller;

    private Request $request;

    public function __construct()
    {
        $this->setMethod();
        $this->setUri();
        $this->setPayload();
        $this->createRequest();
    }

    public function handle()
    {
        $this->route        = $this->getRoute();
        $this->controller   = $this->getController();

        $this->performAction();
    }

    private function setUri(): void
    {
        $this->uri = substr(
            $uri = $_SERVER['REQUEST_URI'],
            1,
            (strpos($uri, '?') ?: strlen($uri)) - 1
        );
    }

    private function setPayload(): void
    {
        $this->payload = array_merge($this->getQueryString(), $this->getRequestBody());
    }

    private function getRequestBody(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    private function getQueryString(): array
    {
        parse_str($_SERVER['QUERY_STRING'] ?? '', $query);

        return $query;
    }

    private function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    private function createRequest()
    {
        $this->request = new Request($this->payload);
    }

    private function getRoute(): Route
    {
        if (! Route::exists($this->method, $this->uri)) {
            response(['message' => 'Not found'], 404);
        }

        return Route::parse($this->method, $this->uri);
    }

    private function getController()
    {
        if (! class_exists($class = "App\\Controllers\\{$this->route->controller}")) {
            response(['message' => 'Not found'], 404);
        }

        return new $class;
    }

    private function performAction()
    {
        if (! method_exists($this->controller, $this->route->action)) {
            response(['message' => 'Not found'], 404);
        }

        call_user_func_array([$this->controller, $this->route->action], [$this->request]);
    }



}