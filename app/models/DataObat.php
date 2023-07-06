<?php
namespace app\models;

use app\config\Database;

class DataObat {

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
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
			$query = "SELECT * FROM `obat` WHERE 
			`kd_obat` LIKE :keyword OR `nm_obat` LIKE :keyword
			ORDER BY `kd_obat` DESC";
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

	public function obatById($kd_obat)
	{
		try{
			$dbh = $this->conn;
			$sql = "SELECT * FROM obat WHERE kd_obat = :kd_obat";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':kd_obat', $kd_obat);
			$stmt->execute();

			$obat = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $obat;
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function store($data)
	{
		try{
			$dbh = $this->conn;

			$addNewUser = $dbh->prepare("INSERT INTO obat (kd_obat, nm_obat, jenis_obat, harga, stok) VALUES (:kd_obat, :nm_obat, :jenis_obat, :harga, :stok)");
			$addNewUser->bindParam(':kd_obat', $data['kd_obat']);
			$addNewUser->bindParam(':nm_obat', $data['nm_obat']);
			$addNewUser->bindParam(':jenis_obat', $data['jenis_obat']);
			$addNewUser->bindParam(':harga', $data['harga']);
			$addNewUser->bindParam(':stok', $data['stok']);

			$addNewUser->execute();

			return $addNewUser->rowCount();
		} catch (\PDOException $e){
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function update($data, $kd_obat)
	{
		try{
			$dbh = $this->conn;
			$sql = "UPDATE obat SET kd_obat=?, nm_obat=?, jenis_obat=?, harga=?, stok=?  WHERE `kd_obat` = ?";
			
			$update = $dbh->prepare($sql);
			
			$update->execute([$data['kd_obat'], $data['nm_obat'], $data['jenis_obat'], $data['harga'], $data['stok'], $kd_obat]);

			return $update->rowCount();

		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function delete($kd_obat)
	{
		try {
			$dbh = $this->conn;
			$delete = $dbh->prepare("DELETE FROM `obat` WHERE `kd_obat` = :kd_obat");
			$delete->bindParam(":kd_obat", $kd_obat);
			$delete->execute();
			
			$dbh->exec("ALTER TABLE `obat` AUTO_INCREMENT = 1");

			return $delete->rowCount();


		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}
}