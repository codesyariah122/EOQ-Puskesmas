<?php

/**
* @author : Puji Ermanto <pujiermanto@gmail.com>
* @return __construct
* @desc : File ini difungsikan untuk menangani request url dari client dan setiap method menentukan rute mana yang akan di gunakan dari request url di sisi client
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

    // Method ini di fungsikan supaya kita tidak mengulang struktur code untuk menangani request berikut di setiap method rute nya.
    private function addRoute($method, $route, $handler): void {
        $paramPattern = ($method === 'GET') ? '{param}' : '{dataParam}';
        $route = str_replace($paramPattern, '([^/]+)', $route);
        $this->routes[$route] = $handler;
    }

    /**
     * Menambahkan route GET
     * 
     * @param string $route Route yang akan ditambahkan
     * @param string $handler Handler untuk route tersebut
     * @return void
     */
    public function get($route, $handler): void {
       $this->addRoute('GET', $route, $handler);
    }

    /**
     * Menambahkan route POST
     * 
     * @param string $route Route yang akan ditambahkan
     * @param string $handler Handler untuk route tersebut
     * @return void
     */
    public function post($route, $handler): void {
        $this->addRoute('POST', $route, $handler);
    }

    public function put($route, $handler): void {
        $this->addRoute('PUT', $route, $handler);
    }

    public function delete($route, $handler): void {
        $this->addRoute('DELETE', $route, $handler);
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
