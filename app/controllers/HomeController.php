<?php

namespace app\controllers;

use app\models\{WebApp, User};
use app\datasources\UserPrepare;
use app\helpers\{Helpers};

class HomeController {

	public $helpers;

	public function __construct()
	{
		$this->helpers = new Helpers;
	}

	public function views($views, $param)
	{
		$model = new WebApp;
		$data = $model->getData();
		$users = new User;
		$rows_count = $users->get_user_data("SELECT COUNT(*) AS total FROM admin")->fetch(\PDO::FETCH_ASSOC);

		$meta = $model->getMetaTag($param['title']);
		$partials = $model->getPartials($param['page']);
		$helpers = $this->helpers;

		foreach($views as $view):
			require_once $view;
		endforeach;
	}

	public function index() 
	{
		session_start();

		$prepare_views = [
			'header' => 'app/views/layout/app/header.php',
			'home' => 'app/views/home.php',
			'footer' => 'app/views/layout/app/footer.php',
		];

		$data = [
			'title' => 'Aplikasi EOQ',
			'page' => 'home',
		];


		$this->views($prepare_views, $data);
	}

	public static function create_user()
	{
		try {
			$users = new User;
			$query = "SELECT * FROM `admin`";
			$row_counts = $users->get_user_data($query)->rowCount();

			if($row_counts > 0) {
				$results = $users->get_user_data($query)->fetchAll(\PDO::FETCH_ASSOC);
				header('Location: /', true);
				exit();
			} else {
				$user_prepare = new UserPrepare;
				$data_user = $users->create_new_user($user_prepare->user_data());
			}

		} catch (\PDOException $e) {
			echo "Terjadi kesalahan : ".$e->getMessage();
		}

	}

}