<?php

namespace app\config;

class Environment {

	public function config()
	{
		$dotenv = parse_ini_file('.env');

		define('HOST',$dotenv['HOST_DB']);
		define('USER',$dotenv['USER_DB']);
		define('PASSWORD',$dotenv['USER_PW']);
		define('DB',$dotenv['DB']);
	}
}