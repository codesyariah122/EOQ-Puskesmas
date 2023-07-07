<?php

namespace app\config;

class Environment {

	public function config()
	{
		$dotenv = parse_ini_file('.env');

		if (!defined('HOST')) {
            define('HOST', $dotenv['HOST_DB']);
        }

        if (!defined('USER')) {
            define('USER', $dotenv['USER_DB']);
        }

        if (!defined('PASSWORD')) {
            define('PASSWORD', $dotenv['USER_PW']);
        }

        if (!defined('DB')) {
            define('DB', $dotenv['DB']);
        }
	}
}