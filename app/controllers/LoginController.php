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

		$page = $param['page'];

		foreach($views as $view):
			require_once $view;
		endforeach;
	}

	public function index() 
	{
		session_start();

		if(isset($_SESSION['token'])) {
			header("Location: /dashboard/{$_SESSION['role']}", 1);
		}
		
		$prepare_views = [
			'header' => 'app/views/layout/app/header.php',
			'login' => 'app/views/login.php',
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
		if(empty($username) || empty($password)) {
			$data = [
				'error' => true,
				'message' => 'Form login harus di isi dengan benar!'
			];
			echo json_encode($data);
		} else {	
			$userModel = new User;
			$user = $userModel->getUserByUsername($username);

			if (!$user) {
				$data = [
					'error' => true,
					'message' => 'User, tidak ditemukan / belum terdaftar!'
				];
				echo json_encode($data);
			} else {

				if(!password_verify($password, $user['password'])) {
					$data = [
						'error' => true,
						'message' => 'Username / password, salah!'
					];
					echo json_encode($data);
				} else {
					$generate_token = $this->helpers->generate_token();
					$_SESSION['user_id'] = $user['kd_admin'];
					$_SESSION['name'] = $user['nm_lengkap'];
					$_SESSION['username'] = $user['username'];
					$_SESSION['role'] = $user['role'];
					$_SESSION['token'] = $generate_token;
					$_SESSION['login_time'] = time();

					$data = [
						'success' => true,
						'message' => "Welcome, {$user['username']}",
						'data' => [
							'username' => $_SESSION['username'],
							'role' => $_SESSION['role'],
							'token' => $_SESSION['token'],
							'login_time' => $_SESSION['login_time']
						]
					];

					echo json_encode($data);
					exit();
				}
			}
		}


	}

	public function logout()
	{
		session_start();
		$user_data = [
			'success' => true,
			'message' => "Anda akan keluar dari dashboard, {$_SESSION['username']}",
			'data' => [
				'username' => $_SESSION['username'],
				'token' => $_SESSION['token']
			]
		];

		echo json_encode($user_data);

        // Hapus semua data session
		session_unset();
        // Hancurkan session
		session_destroy();
        // Redirect ke halaman login atau halaman lainnya
		// header('Location: /?logut=user_logout');
		unset($_SESSION['username']);
		unset($_SESSION['user_id']);
		unset($_SESSION['token']);
		exit();
	}
}