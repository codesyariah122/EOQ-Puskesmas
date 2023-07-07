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
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}


	function searchData($keyword, $limitStart, $limit)
	{
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

			$pengajuanObat = $dbh->prepare("INSERT INTO eoq (kd_obat, k_tahun, b_simpan, b_pesan) VALUES (:kd_obat, :k_tahun, :b_simpan, :b_pesan)");
			$pengajuanObat->bindParam(':kd_obat', $data['kd_obat']);
			$pengajuanObat->bindParam(':k_tahun', $data['k_tahun']);
			$pengajuanObat->bindParam(':b_simpan', $data['b_simpan']);
			$pengajuanObat->bindParam(':b_pesan', $data['b_pesan']);

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