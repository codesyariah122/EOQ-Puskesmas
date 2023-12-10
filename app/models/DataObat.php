<?php

namespace app\models;

use app\config\Database;

class DataObat
{

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
	}

	public function maxKdObat()
	{
		try {
			$dbh = $this->conn;
			$query = "SELECT id FROM obat ORDER BY id DESC LIMIT 1";
			$stmt = $dbh->query($query);

			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			// var_dump($result); die;
			if ($result) {
				return $result['id'];
			} else {
				return;
			}
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function countAllData()
	{
		try {
			$query = "SELECT COUNT(*) AS total FROM obat";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $result['total'];
		} catch (\PDOException $e) {
			throw new Exception("Error: " . $e->getMessage());
		}
	}

	public function countSearchData($keyword)
	{
		try {
			$query = "SELECT COUNT(*) AS total FROM obat WHERE kd_obat LIKE :keyword OR nm_obat LIKE :keyword OR jenis_obat LIKE :keyword";
			$stmt = $this->conn->prepare($query);
			$stmt->bindValue(':keyword', "%$keyword%", \PDO::PARAM_STR);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $result['total'];
		} catch (\PDOException $e) {
			throw new Exception("Error: " . $e->getMessage());
		}
	}

	public function getAllStock()
	{
		try {
			$query = "SELECT CAST(SUM(stok) AS SIGNED) AS total_stock FROM obat";
			$stmt = $this->conn->query($query);
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $result['total_stock'] ?? 0;
		} catch (\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function all($query)
	{
		try {
			$dbh = $this->conn;
			$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$sql = $dbh->query($query);
			$rows = [];

			while ($row = $sql->fetch(\PDO::FETCH_ASSOC)) :
				$rows[] = $row;
			endwhile;

			return $rows;
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function searchData($keyword, $limitStart, $limit)
	{

		try {
			$dbh = $this->conn;
			 $query = "SELECT obat.*, stock_opname.sisa_stok 
                  FROM `obat` 
                  LEFT JOIN stock_opname ON obat.kd_obat = stock_opname.kd_obat 
                  WHERE obat.`kd_obat` LIKE :keyword 
                    OR obat.`nm_obat` LIKE :keyword 
                    OR obat.`jenis_obat` LIKE :keyword
                  ORDER BY obat.`kd_obat` DESC";
                  
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
			echo "Ooops error : " . $e->getMessage();
		}
	}

	public function obatById($kd_obat)
	{
		try {
			$dbh = $this->conn;
			$sql = "SELECT * FROM obat WHERE kd_obat = :kd_obat";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':kd_obat', $kd_obat);
			$stmt->execute();

			$obat = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $obat;
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function store($data, $id)
	{
		try {
			$dbh = $this->conn;

			$addNewObat = $dbh->prepare("INSERT INTO obat (id, kd_obat, nm_obat, isi, satuan, jenis_obat, harga, stok) VALUES (:id, :kd_obat, :nm_obat, :isi, :satuan, :jenis_obat, :harga, :stok)");
			$addNewObat->bindParam(':id', $id);
			$addNewObat->bindParam(':kd_obat', $data['kd_obat']);
			$addNewObat->bindParam(':nm_obat', $data['nm_obat']);
			$addNewObat->bindParam(':isi', $data['isi']);
			$addNewObat->bindParam(':satuan', $data['satuan']);
			$addNewObat->bindParam(':jenis_obat', $data['jenis_obat']);
			$addNewObat->bindParam(':harga', $data['harga']);
			$addNewObat->bindParam(':stok', $data['stok']);

			$addNewObat->execute();

			return $addNewObat->rowCount();
		} catch (\PDOException $e) {
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function update($data, $kd_obat)
	{
		try {
			$dbh = $this->conn;
			$sql = "UPDATE obat SET kd_obat=?, nm_obat=?, jenis_obat=?, harga=?, stok=?  WHERE `kd_obat` = ?";

			$update = $dbh->prepare($sql);

			$update->execute([$data['kd_obat'], $data['nm_obat'], $data['jenis_obat'], $data['harga'], $data['stok'], $kd_obat]);

			return $update->rowCount();
		} catch (\PDOException $e) {
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
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function updateByBeli($data)
	{
		try {
			$dbh = $this->conn;
			$sql = "UPDATE obat SET stok=?  WHERE `kd_obat` = ?";

			$update = $dbh->prepare($sql);

			$update->execute([$data['stok'], $data['kd_obat']]);

			return $update->rowCount();
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}
}
