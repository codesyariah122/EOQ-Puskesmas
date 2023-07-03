<?php
// Load app
require_once 'vendor/autoload.php';

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

// Data user
$app->get('/dashboard/data-user', 'UserDataController@index');
$app->get('/dashboard/data-user/{param}', 'UserDataController@edit');


// Jalankan router
$app->run();