<?php
// Load app
require_once 'vendor/autoload.php';

// Inisialisasi Router
use app\config\Router;
$app = new Router;

// Menambahkan rute ke router
// Homepage rute
$app->get('/', 'HomeController@index');
$app->post('/create-user', 'HomeController@create_user');

// Autentikasi rute
$app->get('/login', 'LoginController@index');
$app->post('/auth-login', 'LoginController@authenticate');
$app->post('/logout', 'LoginController@logout');

// Dashboard rute
$app->get('/dashboard/admin', 'AdminController@index');

// Data user
$app->get('/dashboard/data-user', 'UserDataController@index');
$app->get('/lists/data-user', 'UserDataController@all');
// add new user
$app->post('/add/data-user', 'UserDataController@store');
// edit user
$app->get('/dashboard/data-user/{param}', 'UserDataController@edit');
$app->put('/update/data-user/{dataParam}', 'UserDataController@update');
// delete user
$app->put('/delete/data-user/{dataParam}', 'UserDataController@delete');

// Jalankan router
$app->run();