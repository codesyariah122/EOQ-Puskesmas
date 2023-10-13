<?php
// Load app
require_once 'app/config/Autoload.php';

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
$app->post('/auth-logout', 'LoginController@logout');

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

// Pembelian
$app->get('/dashboard/pembelian', 'PembelianController@index');
$app->get('/lists/pembelian', 'PembelianController@all');
$app->post('/add/pembelian', 'PembelianController@store');
// edit data obat
$app->get('/dashboard/pembelian/{param}', 'PembelianController@edit');
$app->put('/update/pembelian/{dataParam}', 'PembelianController@update');
// delete data obat
$app->delete('/delete/pembelian/{dataParam}', 'PembelianController@delete');

// Laporan Pembelian
$app->get('/dashboard/laporan-pembelian', 'LaporanPembelianController@index');
$app->get('/lists/laporan-pembelian', 'LaporanPembelianController@all');
$app->post('/print/laporan-pembelian', 'LaporanPembelianController@print');

// Chart laporan pembelian
$app->get('/dashboard/chart/laporan-pembelian', 'ChartLaporanBeliController@all');

// Log pembelian
$app->get('/dashboard/log-pembelian', 'LaporanPembelianController@logPembelian');

// Jalankan router
$app->run();