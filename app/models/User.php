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

	public function get_user_first($query)
	{
		try {
			$dbh = $this->conn;
			$users = $dbh->query($query);
			return $users;
		} catch (\PDOException $e) {
			echo "Terjadi kesalahan: " . $e->getMessage();
		}
	}

	public function create_new_user($params)
	{
		try {
			$dbh = $this->conn;
			
			$query = "INSERT INTO `admin` (id, kd_admin, nm_lengkap, alamat, notlp, username, role, password) VALUES (:id, :kd_admin, :nm_lengkap, :alamat, :notlp, :username, :role, :password)";
			$stmt = $dbh->prepare($query);

			foreach($params as $idx => $data):
				$kd = $data['kd_admin'].'0'.$idx+1;
				$stmt->bindParam(':id', $data['id']);
				$stmt->bindParam(':kd_admin', $kd);
				$stmt->bindParam(':nm_lengkap', $data['nm_lengkap']);
				$stmt->bindParam(':alamat', $data['alamat']);
				$stmt->bindParam(':notlp', $data['notlp']);
				$stmt->bindParam(':username', $data['username']);
				$stmt->bindParam(':role', $data['role']);
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

	public function countAllData()
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM admin";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (\PDOException $e) {
            echo "Ooops error : ".$e->getMessage();
        }
    }

    public function countSearchData($keyword)
    {
        try {
            $query = "SELECT COUNT(*) AS total FROM admin WHERE kd_admin LIKE :keyword OR nm_lengkap LIKE :keyword OR role LIKE :keyword";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':keyword', "%$keyword%", \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (\PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
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


	function searchData($keyword, $limitStart, $limit){

		try {
			$dbh = $this->conn;
			$query = "SELECT * FROM `admin` WHERE 
			`kd_admin` LIKE :keyword OR `nm_lengkap` LIKE :keyword OR `role` LIKE :keyword ORDER BY `id` DESC";
			if ($limitStart !== null && $limit !== null) {
				$query .= " LIMIT $limitStart, $limit";
			}
			$stmt = $dbh->prepare($query);
	        $keyword = "%$keyword%";
	        $stmt->bindParam(':keyword', $keyword);
	        $stmt->execute();
	        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

	        return $results;

		} catch (\PDOException $e) {
			echo "Ooops error : ".$e->getMessage();
		}
	}

	public function userById($kd_admin)
	{
		try{
			$dbh = $this->conn;
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

	public function store($data, $id)
	{
		try{
			$dbh = $this->conn;

			$addNewUser = $dbh->prepare("INSERT INTO admin (id, kd_admin, nm_lengkap, password, alamat, notlp, username, role) VALUES (:id, :kd_admin, :nm_lengkap, :password, :alamat, :notlp, :username, :role)");
			$addNewUser->bindParam(':id', $id);
			$addNewUser->bindParam(':kd_admin', $data['kd_admin']);
			$addNewUser->bindParam(':nm_lengkap', $data['nm_lengkap']);
			$addNewUser->bindParam(':password', $data['password']);
			$addNewUser->bindParam(':alamat', $data['alamat']);
			$addNewUser->bindParam(':notlp', $data['notlp']);
			$addNewUser->bindParam(':username', $data['username']);
			$addNewUser->bindParam(':role', $data['role']);

			$addNewUser->execute();

			return $addNewUser->rowCount();
		} catch (\PDOException $e){
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function update($data, $kd_admin)
	{
		try{
			$dbh = $this->conn;
			$sql = "UPDATE admin SET kd_admin=?, nm_lengkap=?, alamat=?, notlp=?, username=?, password=? WHERE `kd_admin` = ?";
			
			$update = $dbh->prepare($sql);
			
			$update->execute([$data['kd_admin'], $data['nm_lengkap'], $data['alamat'], $data['notlp'], $data['username'], $data['password'], $kd_admin]);

			return $update->rowCount();

		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function delete($kd_admin)
	{
		try {
			$dbh = $this->conn;
			$delete = $dbh->prepare("DELETE FROM `admin` WHERE `kd_admin` = :kd_admin");
			$delete->bindParam(":kd_admin", $kd_admin);
			$delete->execute();
			
			$dbh->exec("ALTER TABLE admin AUTO_INCREMENT = 1");

			return $delete->rowCount();


		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
}