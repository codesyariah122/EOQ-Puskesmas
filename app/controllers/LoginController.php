<?php

namespace app\controllers;

use app\models\{User};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class LoginController
{

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

		foreach ($views as $view) :
			require_once $view;
		endforeach;
	}

	public function index()
	{
		session_start();

		if (isset($_SESSION['token'])) {
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
		$expiryTime = time() + (7 * 24 * 60 * 60);

		// Mengatur waktu kedaluwarsa sesi PHP ke 7 hari (7 * 24 jam * 60 menit * 60 detik)
		session_set_cookie_params(7 * 24 * 60 * 60);

		session_start();
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Validasi input
		if (empty($username) || empty($password)) {
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

				if (!password_verify($password, $user['password'])) {
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
					$_SESSION['login_time'] = $expiryTime;
					$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

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
		// sleep(30);
		$username = $_SESSION['username'];

		$user_data = [
			'success' => true,
			'message' => "Anda akan keluar dari dashboard, $username",
			'data' => [
				'username' => $username,
			],
		];
		session_unset();
		session_destroy();
		header('Content-Type: application/json');


		echo json_encode($user_data);
	}
}
