<?php
namespace app\config;

use app\config\Environment;

class Database {

	public $env, $conn;

	public function __construct()
	{	
		$this->env = new Environment;
		$this->env->config();
	}

	public function connection()
	{
		$servername = HOST;
		$username = USER;
		$password = PASSWORD;
		$dbname = DB;

		try {
			$this->conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $this->conn;
		} catch (\PDOException $e) {
			echo "Koneksi ke database gagal: " . $e->getMessage();
		}
	}
}
