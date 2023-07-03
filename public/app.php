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
$app = new Router;

// Menambahkan rute ke router
$app->get('/', 'HomeController@index');
$app->post('/create-user', 'HomeController@create_user');
$app->get('/login', 'LoginController@index');
$app->post('/auth-login', 'LoginController@authenticate');
$app->post('/logout', 'LoginController@logout');

// Dashboard Admin
$app->get('/dashboard/{param}', 'AdminController@index');
$app->get('/data-user', 'AdminController@all_user');


// Jalankan router
$app->run();