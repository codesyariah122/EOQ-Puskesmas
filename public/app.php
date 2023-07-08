<?php
// Load app
require_once 'vendor/autoload.php';

// Inisialisasi Router
use app\config\Router;
$app = new Router;

// Menambahkan rute ke router
// Homepage rute
$app->get('/', 'HomeController@index');
$app->get('/home', 'HomeController@index');
$app->get('/about', 'HomeController@about');
$app->post('/create-user', 'HomeController@create_user');

// Autentikasi rute
$app->get('/login', 'LoginController@index');
$app->post('/auth-login', 'LoginController@authenticate');
$app->post('/logout', 'LoginController@logout');

// Dashboard feature rute
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
// add new obat
$app->post('/add/data-obat', 'DataObatController@store');
// edit data obat
$app->get('/dashboard/data-obat/{param}', 'DataObatController@edit');
$app->put('/update/data-obat/{dataParam}', 'DataObatController@update');
// delete data obat
$app->delete('/delete/data-obat/{dataParam}', 'DataObatController@delete');

// Pengajuan obat
$app->get('/dashboard/pengajuan-obat', 'PengajuanObatController@index');
$app->get('/options/lists-obat', 'PengajuanObatController@lists_obat');
$app->post('/add/pengajuan-obat', 'PengajuanObatController@store');

// Laporan analisa EOQ
$app->get('/dashboard/laporan-eoq', 'LaporanEoqController@index');
$app->get('/lists/laporan-eoq', 'LaporanEoqController@all');
$app->post('/print/laporan-eoq', 'LaporanEoqController@print');

// Pembelian & laporan Pembelian
$app->get('/dashboard/pembelian', 'PembelianController@index');
$app->post('/add/pembelian', 'PembelianController@store');
$app->get('/dashboard/laporan-pembelian', 'LaporanPembelianController@index');
$app->get('/lists/laporan-pembelian', 'LaporanPembelianController@all');
$app->post('/print/laporan-pembelian', 'LaporanPembelianController@print');

// Jalankan router
$app->run();