<?php

namespace app\controllers;

use app\models\{User};
use app\datasources\UserPrepare;
use app\helpers\{Helpers};
use app\datasources\WebApp;

class UserController {

	public $helpers, $data_model;

	public function __construct()
	{
		session_start();
		
		if(!isset($_SESSION['token'])) {
			header("Location: /?error=forbaiden", 1);
		}

		$this->helpers = new Helpers;
		$this->data_model = new User;
	}

	public function views($views, $param)
	{
		$helpers = $this->helpers;
		$webApp = new WebApp;
		$data = $webApp->getData();
		$meta = $webApp->getMetaTag($param['title']);
		$welcome_text = "Welcome , {$param['data']['name']}";
		$description = "Sistem Informasi Pengelolaan Pengadaan Obat Balai Kesehatan";
		
		$page = $param['page'];

		$is_mobile = $helpers->isMobileDevice();

		$partials = $webApp->getPartials($param['page']);


		foreach($views as $view):
			require_once $view;
		endforeach;
	}

	public function index($param) 
	{
		$views = 'app/views/user/index.php';

		$prepare_views = [
			'header' => 'app/views/layout/dashboard/header.php',
			'contents' => $views,
			'footer' => 'app/views/layout/dashboard/footer.php',
		];

		$user_login = $this->data_model->getUserByUsername($_SESSION['username']);
		$role = ucfirst($user_login['role']);
		$data = [
			'title' => "Aplikasi EOQ - Dashboard {$role}",
			'page' => $user_login['role'],
			'data' => [
				'name' => ucfirst($user_login['nm_lengkap'])
			],
		];

		$this->views($prepare_views, $data);
	}

}