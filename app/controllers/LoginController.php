<?php

namespace app\controllers;

use app\models\{WebApp, User};
use app\helpers\{Helpers};

class LoginController {

	private $helpers;

	public function __construct()
	{
		$this->helpers = new Helpers;
	}

	public function views($views, $param)
	{
		$model = new WebApp;
		$data = $model->getData();
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

		if(isset($_SESSION['token'])) {
			header("Location: /dashboard/{$_SESSION['username']}", 1);
		}
		
		$prepare_views = [
			'header' => 'app/views/layout/app/header.php',
			'home' => 'app/views/home.php',
			'footer' => 'app/views/layout/app/footer.php',
		];

		$data = [
			'title' => 'Aplikasi EOQ - Login',
			'page' => 'login',
		];

		$this->views($prepare_views, $data);
	}

	public function authenticate()
	{

		session_start();
		$username = $_POST['username'];
		$password = $_POST['password'];

        // Validasi input
		$userModel = new User;
		$user = $userModel->getUserByUsername($username);

		if (!$user) {
            // Kombinasi username dan password tidak valid
            // Tampilkan pesan kesalahan atau redirect ke halaman login
			header('Location: /login?error=user_not_found');
		} else {
            // Login berhasil
            // Set session atau token untuk pengguna yang diotentikasi
            // Redirect ke halaman dashboard atau halaman lainnya
			if(!password_verify($password, $user['password'])) {
				header('Location: /login?error=password_wrong');
			} else {
				$generate_token = $this->helpers->generate_token();
				$_SESSION['user_id'] = $user['kd_admin'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['token'] = $generate_token;
				header("Location: /dashboard/{$username}");
				exit();
			}
		}
	}
}