<?php
namespace app\models;

use app\config\Database;

class Pembelian {

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
	}

	public function lastIdBeli()
	{
		try {
			$dbh = $this->conn;
			$query = "SELECT id FROM beli ORDER BY id DESC LIMIT 1";
			$stmt = $dbh->query($query);

			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			// var_dump($result); die;
			if($result) {
				return $result['id'];
			} else {
				return ;
			}
		} catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function countAllData()
    {
    	try {
            $query = "SELECT COUNT(*) AS total FROM beli";
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
            $query = "SELECT COUNT(*) AS total FROM beli WHERE kd_obat LIKE :keyword";
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
		} catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function printLaporan($query, $kd_obat_array, $beli_id_array)
	{
		try {
			$dbh = $this->conn;
			$stmt = $dbh->prepare($query);
			$stmt->execute(array_merge($kd_obat_array, $beli_id_array));

			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

			return $results;
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}


	function searchData($keyword, $limitStart, $limit)
	{
		try {
			$dbh = $this->conn;


			$query = "SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, beli.* FROM obat JOIN beli ON obat.kd_obat = beli.kd_obat WHERE beli.kd_obat LIKE :keyword OR obat.nm_obat LIKE :keyword OR obat.jenis_obat LIKE :keyword OR beli.tgl_beli LIKE :keyword OR beli.kd_beli LIKE :keyword ORDER BY beli.id DESC";

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

	public function pembelianById($kd_obat)
	{
		try{
			$dbh = $this->conn;
			$sql = "SELECT * FROM beli WHERE kd_obat = :kd_obat";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':kd_obat', $kd_obat);
			$stmt->execute();

			$beli = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $beli;
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function store($data, $id)
	{
		try{
			$dbh = $this->conn;

			$pembelian = $dbh->prepare("INSERT INTO beli (id, kd_beli, tgl_beli, kd_obat, jumlah) VALUES (:id, :kd_beli, :tgl_beli, :kd_obat, :jumlah)");
			$pembelian->bindParam(':id', $id);
			$pembelian->bindParam(':kd_beli', $data['kd_beli']);
			$pembelian->bindParam(':tgl_beli', $data['tgl_beli']);
			$pembelian->bindParam(':kd_obat', $data['kd_obat']);
			$pembelian->bindParam(':jumlah', $data['jumlah']);

			$pembelian->execute();

			return $pembelian->rowCount();
			
		} catch (\PDOException $e){
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function update($data, $kd_obat)
	{
	}

	public function delete($kd_obat)
	{
	}
}