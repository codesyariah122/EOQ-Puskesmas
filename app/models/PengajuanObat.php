<?php
namespace app\models;

use app\config\Database;

class PengajuanObat {

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
	}


	public function countAllData()
    {
    	try {
            $query = "SELECT COUNT(*) AS total FROM eoq";
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
            $query = "SELECT COUNT(*) AS total FROM eoq WHERE kd_obat LIKE :keyword";
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

	public function printLaporan($query, $kd_obat_array, $eoq_id_array)
	{
		try {
			$dbh = $this->conn;
			$stmt = $dbh->prepare($query);
			$stmt->execute(array_merge($kd_obat_array, $eoq_id_array));

			$results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

			return $results;
		} catch (\PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function searchData($keyword, $limitStart, $limit)
	{
		try {
			$dbh = $this->conn;

			// $query = "SELECT * FROM `obat` WHERE 
			// `kd_obat` LIKE :keyword OR `nm_obat` LIKE :keyword 
			// OR `jenis_obat` LIKE '%$keyword%'
			// ORDER BY `kd_obat` DESC";
			$query = "SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, eoq.* FROM obat JOIN eoq ON obat.kd_obat = eoq.kd_obat WHERE eoq.kd_obat LIKE :keyword OR obat.nm_obat LIKE :keyword OR obat.jenis_obat LIKE :keyword OR eoq.k_tahun LIKE :keyword ORDER BY eoq.id DESC";

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

	public function pengajuanById($kd_obat)
	{
		try{
			$dbh = $this->conn;
			$sql = "SELECT * FROM eoq WHERE kd_obat = :kd_obat";
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

			$pengajuanObat = $dbh->prepare("INSERT INTO eoq (kd_obat, k_tahun, b_simpan, b_pesan, jumlah_eoq, intval_time) VALUES (:kd_obat, :k_tahun, :b_simpan, :b_pesan, :jumlah_eoq, :intval_time)");
			$pengajuanObat->bindParam(':kd_obat', $data['kd_obat']);
			$pengajuanObat->bindParam(':k_tahun', $data['k_tahun']);
			$pengajuanObat->bindParam(':b_simpan', $data['b_simpan']);
			$pengajuanObat->bindParam(':b_pesan', $data['b_pesan']);
			$pengajuanObat->bindParam(':jumlah_eoq', $data['jumlah_eoq']);
			$pengajuanObat->bindParam(':intval_time', $data['intval_time']);

			$pengajuanObat->execute();

			return $pengajuanObat->rowCount();
			
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