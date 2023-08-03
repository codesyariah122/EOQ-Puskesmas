<?php
/**
 * @author Puji Ermanto <pujiermanto@gmail.com>
 * Please setup config environment for database configuration first & then import db.sql to database
 * */
// Before run app , please import database first

namespace app\controllers;

use app\models\{User};
use app\datasources\UserPrepare;
use app\helpers\{Helpers};
use app\datasources\WebApp;

class HomeController {

	public $helpers;

	public function __construct()
	{
		$this->helpers = new Helpers;
	}

	public function views($views, $param)
	{
		$webApp = new WebApp;
		$data = $webApp->getData();

		$users = new User;

		$rows_count = $users->get_user_first("SELECT COUNT(*) AS total FROM admin")->fetch(\PDO::FETCH_ASSOC);

		$meta = $webApp->getMetaTag($param['title']);
		$partials = $webApp->getPartials($param['page']);
		$helpers = $this->helpers;
		$page = $param['page'];

		foreach($views as $view):
			require_once $view;
		endforeach;
	}

	public function index($param) 
	{
		session_start();
		$views = 'app/views/home.php';
		$prepare_views = [
			'header' => 'app/views/layout/app/header.php',
			'home' => $views,
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
			$row_counts = $users->get_user_first($query)->rowCount();

			if($row_counts > 0) {
				$results = $users->get_user_first($query)->fetchAll(\PDO::FETCH_ASSOC);
				header('Location: /login', true);
				exit();
			} else {
				$user_prepare = new UserPrepare;
				$data_user = $users->create_new_user($user_prepare->user_data());
				header('Location: /login', true);
				exit();
			}

		} catch (\PDOException $e) {
			echo "Terjadi kesalahan : ".$e->getMessage();
		}

	}

	public function about()
	{
		session_start();

		$prepare_views = [
			'header' => 'app/views/layout/app/header.php',
			'home' => 'app/views/about.php',
			'footer' => 'app/views/layout/app/footer.php',
		];

		$data = [
			'title' => 'Aplikasi EOQ - About Page',
			'page' => 'about',
		];


		$this->views($prepare_views, $data);
	}

}