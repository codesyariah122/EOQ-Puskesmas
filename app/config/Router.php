<?php

/**
* @author : Puji Ermanto <pujiermanto@gmail.com>
* @return __construct
* @desc : File ini akan mengambil setiap method dalam file controller kemudian menjalankan nya secara synchronous
**/

namespace app\config;

use app\controllers\NotFoundController;

class Router {

    private $routes = [];
    private $notfound;

    public function __construct()
    {
        $this->notfound = new NotFoundController;
    }

    /**
     * Menambahkan route GET
     * 
     * @param string $route Route yang akan ditambahkan
     * @param string $handler Handler untuk route tersebut
     * @return void
     */
    public function get($route, $handler): void {
       $route = str_replace('{param}', '([^/]+)', $route);
       $this->routes[$route] = $handler;
    }

    /**
     * Menambahkan route POST
     * 
     * @param string $route Route yang akan ditambahkan
     * @param string $handler Handler untuk route tersebut
     * @return void
     */
    public function post($route, $handler): void {
        $route = str_replace('{param}', '([^/]+)', $route);
        $this->routes[$route] = $handler;
    }

    public function put($route, $handler): void {
        $route = str_replace('{dataParam}', '([^/]+)', $route);
        $this->routes[$route] = $handler;
    }

    public function delete($route, $handler): void {
        $route = str_replace('{dataParam}', '([^/]+)', $route);
        $this->routes[$route] = $handler;
    }

    /**
     * Menjalankan router
     * 
     * @return void
     */
    public function run(): void {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = strtok($uri, '?');

        foreach ($this->routes as $route => $handler) {
            $pattern = '#^' . $route . '$#';
            if (preg_match($pattern, $uri, $matches)) {
                $handlerParts = explode('@', $handler);
                $controllerName = $handlerParts[0];
                $methodName = $handlerParts[1];

                $controllerNamespace = 'app\controllers\\' . $controllerName;
                $controller = new $controllerNamespace();

                // var_dump($methodName); die;

                array_shift($matches); // Hapus elemen pertama (seluruh kecocokan URI)
                $dataParam = end($matches); // Ambil data user dari route parameter

                // var_dump($controllerName); die;

                // Panggil method pada controller dengan parameter data user
                call_user_func([$controller, $methodName], $dataParam);

                return;
            }
        }

        http_response_code(404);
        header("HTTP/1.0 404 Not Found");

        $this->notfound->run();
    }
}
