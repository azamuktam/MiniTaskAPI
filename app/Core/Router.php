<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\Response;

/**
 * Router
 *
 * Handles registering routes and dispatching requests to controllers.
 * Supports dynamic parameters defined with curly braces (e.g., /tasks/{id}).
 */
class Router
{
    /** @var array<int, array<string, mixed>> List of registered routes */
    private array $routes = [];

    /**
     * Register a GET route.
     *
     * @param string $path    The URI path (e.g., '/tasks').
     * @param array  $handler The controller class and method [Class::class, 'method'].
     * @return void
     */
    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    /**
     * Register a POST route.
     *
     * @param string $path    The URI path.
     * @param array  $handler The controller class and method.
     * @return void
     */
    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    /**
     * Register a PUT route.
     *
     * @param string $path    The URI path.
     * @param array  $handler The controller class and method.
     * @return void
     */
    public function put(string $path, array $handler): void
    {
        $this->add('PUT', $path, $handler);
    }

    /**
     * Register a DELETE route.
     *
     * @param string $path    The URI path.
     * @param array  $handler The controller class and method.
     * @return void
     */
    public function delete(string $path, array $handler): void
    {
        $this->add('DELETE', $path, $handler);
    }

    /**
     * Internal method to add a route to the collection.
     *
     * Converts route parameters like {id} into Regex groups.
     *
     * @param string $method  HTTP method.
     * @param string $path    URI path.
     * @param array  $handler Controller handler.
     * @return void
     */
    private function add(string $method, string $path, array $handler): void
    {
        // Convert {param} to regex capture group ([a-zA-Z0-9_]+)
        $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $path);

        $this->routes[] = [
            'method' => $method,
            'pattern' => "#^" . $pattern . "$#",
            'handler' => $handler
        ];
    }

    /**
     * Dispatch the request to the matching route.
     *
     * @param string $uri    The request URI.
     * @param string $method The HTTP request method.
     * @return void
     */
    public function dispatch(string $uri, string $method): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $path, $matches)) {
                array_shift($matches);

                [$handler, $action] = $route['handler'];

                if (is_object($handler)) {
                    $controller = $handler;
                } else {
                    $controller = new $handler();
                }

                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }

        Response::error('Not Found', 404);
    }
}