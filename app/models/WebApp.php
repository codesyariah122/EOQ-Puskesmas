<?php
/**
 * @author Puji Ermanto <pujiermanto@gmail.com>
 * @return __constructor
**/

namespace app\models;

use app\helpers\{Helpers};

class WebApp {

	private $helpers, $check_mobile;

	public function __construct()
	{
		$this->helpers = new Helpers;
		$this->check_mobile = $this->helpers->isMobileDevice();
	}

	public function getPartials($page)
	{
		switch($page) {
			case "home":
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'home_content' => 'app/views/home/home_content.php' 
			];
			$scripts = ['/public/assets/js/script.js'];
			break;

			case "create-user":
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'home_content' => 'app/views/home/create_user.php' 
			];
			$scripts = ['/public/assets/js/script.js'];
			break;


			case "login":
			$partials = [
				'loading' => 'app/views/layout/partials/loading.php',
				'login_form' => 'app/views/auth/login_form.php'
			];
			$scripts = ['/public/assets/js/script.js'];
			break;

			case "404":
			$partials = [
				'error_404_content' => 'app/views/errors/content_404.php'
			];
			$scripts = [];
			break;

			default:
			$partials = [];
			$scripts = [];
		}
	

		return [
			'navbar' => 'app/views/layout/partials/navbar.php',
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
				'contentful' => '/public/assets/vendor/js/contentful.browser.min.js',
				'sweetalert' => '/public/assets/vendor/js/sweetalert2@11.js'
			],
		];
	}
}