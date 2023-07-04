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
			return $users;
		} catch (\PDOException $e) {
			return ;
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
		try {
			$query = "SELECT * FROM `admin` WHERE username = :username";
			$stmt = $this->conn->prepare($query);
			$stmt->bindValue(':username', $username);
			$stmt->execute();
			return $stmt->fetch();
		} catch (\PDOException $e) {
			echo "Ooops error : ".$e->getMessage();
		}
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

	public function userById($kd_admin)
	{
		$dbh = $this->conn;
		try{
			$sql = "SELECT * FROM admin WHERE kd_admin = :kd_admin";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':kd_admin', $kd_admin);
			$stmt->execute();

			$user = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $user;
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function update($data, $kd_admin)
	{
		$dbh = $this->conn;
		try{
			$sql = "UPDATE admin SET kd_admin=?, nm_lengkap=?, alamat=?, notlp=?, username=?  WHERE `kd_admin` = ?";
			
			$update = $dbh->prepare($sql);
			
			$update->execute([$data['kd_admin'], $data['nm_lengkap'], $data['alamat'], $data['notlp'], $data['username'], $kd_admin]);

			return $update->rowCount();

		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
}