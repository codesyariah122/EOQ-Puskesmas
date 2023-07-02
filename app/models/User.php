<?php

namespace app\models;

use app\config\Database;

class User {

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
	}

	public function get_user_data($query)
	{
		$db = $this->conn;
		$users = $db->query($query);
		return $users;
	}

	public function create_new_user($params)
	{
		try {
			$db = $this->conn;
			
			$query = "INSERT INTO `admin` (kd_admin, nm_lengkap, alamat, notlp, username, password) VALUES (:kd_admin, :nm_lengkap, :alamat, :notlp, :username, :password)";
			$statement = $db->prepare($query);

			foreach($params as $idx => $data):
				$kd = $data['kd_admin'].'0'.$idx+1;
				$statement->bindParam(':kd_admin', $kd);
				$statement->bindParam(':nm_lengkap', $data['nm_lengkap']);
				$statement->bindParam(':alamat', $data['alamat']);
				$statement->bindParam(':notlp', $data['notlp']);
				$statement->bindParam(':username', $data['username']);
				$statement->bindParam(':password', $data['password']);
				$statement->execute();
			endforeach;
			header('Location: /', 1);
			
		} catch (PDOException $e) {
			echo "Terjadi kesalahan: " . $e->getMessage();
		}

		$connection = null;
	}

	public function getUserByUsername($username)
    {
        $query = "SELECT * FROM `admin` WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
}