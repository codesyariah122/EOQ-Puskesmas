<?php
namespace app\models;

use app\config\Database;

class LogPembelian {
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
		} catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function logPembelianByIdData($kd_beli)
	{
		try{
			$dbh = $this->conn;

			$sql = "SELECT * FROM log_pembelian WHERE kd_beli = :kd_beli";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(':kd_beli', $kd_beli);
			$stmt->execute();

			$beli = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $beli;
		}catch(\PDOException $e){
			echo $e->getMessage();
		}
	}

	public function store($data, $id)
	{
		try {
			$dbh = $this->conn;

			$dbh->beginTransaction();

			$logPembelian = $dbh->prepare("INSERT INTO log_pembelian (id, kd_admin, kd_beli, tgl_beli, kd_obat, jumlah) VALUES (:id, :kd_admin, :kd_beli, :tgl_beli, :kd_obat, :jumlah)");
			$logPembelian->bindParam(':id', $id);
			$logPembelian->bindParam(':kd_admin', $data['kd_admin']);
			$logPembelian->bindParam(':kd_beli', $data['kd_beli']);
			$logPembelian->bindParam(':tgl_beli', $data['tgl_beli']);
			$logPembelian->bindParam(':kd_obat', $data['kd_obat']);
			$logPembelian->bindParam(':jumlah', $data['jumlah']);

			$logPembelian->execute();

			$errorInfo = $logPembelian->errorInfo();
			if ($errorInfo[0] !== '00000') {
				$dbh->rollBack();
				echo "Error executing query: " . $errorInfo[2];
			} else {
				$dbh->commit();

				return $logPembelian->rowCount();
			}

		} catch (\PDOException $e) {
			$dbh->rollBack();
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			$dbh->rollBack();
			echo "Error: " . $e->getMessage();
		}
	}

	public function delete($kd_beli)
	{
		try {
			$dbh = $this->conn;

			$dbh->beginTransaction();

			$delete = $dbh->prepare("DELETE FROM `log_pembelian` WHERE `kd_beli` = :kd_beli");
			$delete->bindParam(":kd_beli", $kd_beli);
			$delete->execute();

			$errorInfo = $delete->errorInfo();
			if ($errorInfo[0] !== '00000') {
				$dbh->rollBack();
				echo "Error executing query: " . $errorInfo[2];
			} else {
				$dbh->commit();

				$dbh->exec("ALTER TABLE `beli` AUTO_INCREMENT = 1");

				return $delete->rowCount();
			}
		} catch (\PDOException $e) {
			$dbh->rollBack();
			echo $e->getMessage();
		}
	}

}