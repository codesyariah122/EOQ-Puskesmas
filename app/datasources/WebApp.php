<?php
/**
 * @author Puji Ermanto <pujiermanto@gmail.com>
 * @return WebApp Data Source
**/

namespace app\datasources;


class WebApp {

	public function getPartials($page)
	{
		switch($page) {
			case "home":
			$navbar = 'app/views/layout/partials/navbar.php';
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'home_content' => 'app/views/contents/home/home_content.php',
				'timeline' => 'app/views/contents/home/timeline.php'
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "about":
			$navbar = 'app/views/layout/partials/navbar.php';
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'home_content' => 'app/views/contents/about/about_content.php' 
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "create-user":
			$navbar = 'app/views/layout/partials/navbar.php';
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'home_content' => 'app/views/contents/home/create_user.php' 
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;


			case "login":
			$navbar = 'app/views/layout/partials/auth/navbar.php';
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'login_form' => 'app/views/contents/auth/login_form.php'
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "404":
			$navbar = 'app/views/layout/partials/errors/navbar.php';
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'error_404_content' => 'app/views/contents/errors/content_404.php'
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "admin":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"admin" => "app/views/contents/dashboard/admin.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "data-user":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"admin" => "app/views/contents/dashboard/data-user.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js'
			];
			break;

			case "data-user-edit":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"edit_user" => "app/views/contents/dashboard/edit/data-user.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js'
			];
			break;

			case "user":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"admin" => "app/views/contents/dashboard/user.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js'
			];
			break;

			case "data-obat":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"admin" => "app/views/contents/dashboard/data-obat.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js'
			];
			break;

			case "data-obat-edit":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"edit_user" => "app/views/contents/dashboard/edit/data-obat.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js'
			];
			break;

			case "pengajuan-obat":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"pengajuan_obat" => "app/views/contents/dashboard/pengajuan-obat.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js'
			];
			break;

			case "laporan-eoq":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"pengajuan_obat" => "app/views/contents/dashboard/laporan-eoq.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js',
				'/public/assets/js/data-consume/pdf.load.js'
			];
			break;

			case "pembelian":
			$navbar = "app/views/layout/partials/dashboard/navbar.php";
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				"sidebar" => "app/views/layout/partials/dashboard/sidebar.php",
				"pengajuan_obat" => "app/views/contents/dashboard/pembelian.php"
			];
			$scripts = [
				'/public/assets/js/script.js', 
				'/public/assets/js/auth/function.js', 
				'/public/assets/js/auth/app.js',
				'/public/assets/js/data-consume/function.js', 
				'/public/assets/js/data-consume/app.js',
				'/public/assets/js/data-consume/pdf.load.js'
			];
			break;

			default:
			$partials = [];
			$scripts = [];
		}
	

		return [
			'navbar' => $navbar,
			'footer_content' => 'app/views/layouts/partials/footer_content.php',
			'views' => $partials,
			'scripts' => $scripts
		];
	}

	public function getMetaTag($title) 
	{	
		return ['head_title' => $title];
	}

	public function getData() 
	{		
		return [
			'logo' => '/public/assets/icon.png',
			'favicon' => '/public/assets/favicon.ico',
			'title' => 'Aplikasi EOQ',
			'tagline' => 'Aplikasi EOQ - System Pengelolaan',
			'brand' => 'Aplikasi EOQ',
			'bg' => '/public/assets/images/bg.jpg',
			'vendor' => [
				'tailwind' => '/public/assets/vendor/js/tailwind.js',
				'fontawesome' => '/public/assets/vendor/css/all.min.css',
				'flowbite' => [
					'css' => '/public/assets/vendor/css/flowbite.min.css',
					'js' => '/public/assets/vendor/js/flowbite.min.js',
				],
				'sweetalert' => '/public/assets/vendor/js/sweetalert2@11.js'
			],
		];
	}
}