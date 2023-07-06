<?php
// Load app
require_once 'vendor/autoload.php';

// Inisialisasi Router
use app\config\Router;
$app = new Router;

// Menambahkan rute ke router
// Homepage rute
$app->get('/', 'HomeController@index');
$app->get('/about', 'HomeController@about');
$app->post('/create-user', 'HomeController@create_user');

// Autentikasi rute
$app->get('/login', 'LoginController@index');
$app->post('/auth-login', 'LoginController@authenticate');
$app->post('/logout', 'LoginController@logout');

// Dashboard rute
// Admin
$app->get('/dashboard/admin', 'AdminController@index');
// User
$app->get('/dashboard/user', 'UserController@index');

// Data user
$app->get('/dashboard/data-user', 'UserDataController@index');
$app->get('/lists/data-user', 'UserDataController@all');
// add new user
$app->post('/add/data-user', 'UserDataController@store');
// edit user
$app->get('/dashboard/data-user/{param}', 'UserDataController@edit');
$app->put('/update/data-user/{dataParam}', 'UserDataController@update');
// delete user
$app->delete('/delete/data-user/{dataParam}', 'UserDataController@delete');

// Data obat
$app->get('/dashboard/data-obat', 'DataObatController@index');
$app->get('/lists/data-obat', 'DataObatController@all');
// Jalankan router
$app->run();