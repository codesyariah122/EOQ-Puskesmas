<?php
spl_autoload_register(function($className) {
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classFile = $classPath . '.php';

     if (file_exists($classFile)) {
        require_once $classFile;
    }
});

// Inisialisasi Router
use app\config\Router;
$router = new Router;

// Menambahkan rute ke router
$router->get('/', 'HomeController@index');
$router->post('/create-user', 'HomeController@create_user');
$router->get('/login', 'LoginController@index');
$router->post('/auth-login', 'LoginController@authenticate');

// Jalankan router
$router->run();