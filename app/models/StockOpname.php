<?php

namespace app\models;

use app\config\Database;

class StockOpname
{

	public $db, $conn;

	public function __construct()
	{
		$this->db = new Database;
		$this->conn = $this->db->connection();
	}

	public function allStockIn()
	{
		try {
			$query = "SELECT CAST(SUM(sisa_stok) AS SIGNED) AS total_stock FROM stock_opname";
			$stmt = $this->conn->query($query);
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			return $result['total_stock'] ?? 0;
		} catch (\PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	public function store($data)
	{
		try {
			$dbh = $this->conn;

			$dbh->beginTransaction();

			$pembelian = $dbh->prepare("INSERT INTO stock_opname (kd_obat, sisa_stok) VALUES (:kd_obat, :sisa_stok)");
			$pembelian->bindParam(':kd_obat', $data['kd_obat']);
			$pembelian->bindParam(':sisa_stok', $data['sisa_stok']);

			$pembelian->execute();

			$errorInfo = $pembelian->errorInfo();
			if ($errorInfo[0] !== '00000') {
				$dbh->rollBack();
				echo "Error executing query: " . $errorInfo[2];
			} else {
				$dbh->commit();

				return $pembelian->rowCount();
			}
		} catch (\PDOException $e) {
			$dbh->rollBack();
			echo "Error PDO: " . $e->getMessage();
		} catch (\Exception $e) {
			$dbh->rollBack();
			echo "Error: " . $e->getMessage();
		}
	}

	public function update($data)
	{
		try {
			$dbh = $this->conn;

			$dbh->beginTransaction();

			$sql = "UPDATE stock_opname SET sisa_stok=? WHERE `kd_obat` = ?";
			$update = $dbh->prepare($sql);
			$update->execute([$data['sisa_stok'], $data['kd_obat']]);

			$errorInfo = $update->errorInfo();
			if ($errorInfo[0] !== '00000') {
				$dbh->rollBack();
				echo "Error executing query: " . $errorInfo[2];
			} else {
				$dbh->commit();

				return $update->rowCount();
			}
		} catch (\PDOException $e) {
			$dbh->rollBack();
			echo $e->getMessage();
		}
	}
}
