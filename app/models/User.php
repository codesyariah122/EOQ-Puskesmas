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
		try {
			$dbh = $this->conn;
			$users = $dbh->query($query);
			// var_dump(!$users); die;
			return $users;
		} catch (\PDOException $e) {
			echo "Terjadi kesalahan: " . $e->getMessage();
		}
	}

	public function create_new_user($params)
	{
		try {
			$dbh = $this->conn;
			
			$query = "INSERT INTO `admin` (id, kd_admin, nm_lengkap, alamat, notlp, username, password) VALUES (:id, :kd_admin, :nm_lengkap, :alamat, :notlp, :username, :password)";
			$stmt = $dbh->prepare($query);

			foreach($params as $idx => $data):
				$kd = $data['kd_admin'].'0'.$idx+1;
				$stmt->bindParam(':id', $data['id']);
				$stmt->bindParam(':kd_admin', $kd);
				$stmt->bindParam(':nm_lengkap', $data['nm_lengkap']);
				$stmt->bindParam(':alamat', $data['alamat']);
				$stmt->bindParam(':notlp', $data['notlp']);
				$stmt->bindParam(':username', $data['username']);
				$stmt->bindParam(':password', $data['password']);
				$stmt->execute();
			endforeach;
			header('Location: /', 1);
			
		} catch (\PDOException $e) {
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

	public function all($query)
	{
		try{
			$dbh = $this->conn;
			$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$sql = $dbh->query($query);
			$rows=[];

			while($row = $sql->fetch(\PDO::FETCH_ASSOC)):
				$rows[] = $row;
			endwhile;

			return $rows;
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
}