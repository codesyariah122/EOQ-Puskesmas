<?php

namespace app\models;

use app\config\Database;

class KebutuhanPertahun
{

    public $db, $conn;

    public function __construct()
    {
        $this->db = new Database;
        $this->conn = $this->db->connection();
    }

    public function lastIdBiaya()
    {
        try {
            $dbh = $this->conn;
            $query = "SELECT id FROM annual_needs ORDER BY id DESC LIMIT 1";
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
            $query = "SELECT COUNT(*) AS total FROM annual_needs";
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
            $query = "SELECT COUNT(*) AS total FROM annual_needs WHERE kd_obat LIKE :keyword";
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

    public function kebutuhanByKdObay($kd_obat)
    {
        try {
            $dbh = $this->conn;
            $sql = "SELECT * FROM annual_needs WHERE kd_obat = :kd_obat";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':kd_obat', $kd_obat);
            $stmt->execute();

            $k_tahunByKdObat = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $k_tahunByKdObat;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function searchData($keyword, $limitStart, $limit)
    {
        try {
            $dbh = $this->conn;
            $query = "SELECT annual_needs.id AS needs_id, annual_needs.kd_obat AS needs_kd_obat, annual_needs.k_tahun, annual_needs.satuan, annual_needs.jumlah,
                  obat.id AS obat_id, obat.kd_obat, obat.nm_obat, obat.jenis_obat, obat.harga, obat.stok
                  FROM `annual_needs`
                  INNER JOIN `obat` ON annual_needs.kd_obat = obat.kd_obat
                  WHERE annual_needs.`kd_obat` LIKE :keyword
                  ORDER BY annual_needs.`id` DESC";

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

    public function totalJumlahKebutuhanPerTahun()
    {
        try {
            $query = "SELECT CAST(SUM(jumlah) AS SIGNED) AS total_jumlah FROM annual_needs";
            $stmt = $this->conn->query($query);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result['total_jumlah'] ?? 0;
        } catch (\PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function store($data)
    {
        try {
            $dbh = $this->conn;

            $addNewObat = $dbh->prepare("INSERT INTO  annual_needs (kd_obat, k_tahun, satuan, jumlah) VALUES (:kd_obat, :k_tahun, :satuan, :jumlah)");
            $addNewObat->bindParam(':kd_obat', $data['kd_obat']);
            $addNewObat->bindParam(':k_tahun', $data['k_tahun']);
            $addNewObat->bindParam(':satuan', $data['satuan']);
            $addNewObat->bindParam(':jumlah', $data['jumlah']);
            $addNewObat->execute();

            return $addNewObat->rowCount();
        } catch (\PDOException $e) {
            echo "Error PDO: " . $e->getMessage();
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update($data, $id)
    {
        try {
            $dbh = $this->conn;

            $dbh->beginTransaction();

            $sql = "UPDATE biaya SET nama=?, biaya_bln=?, jumlah=?, total=? WHERE `id` = ?";
            $update = $dbh->prepare($sql);
            $update->execute([$data['nama'], $data['biaya_bln'], $data['jumlah'], $data['total'], $id]);

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

    public function delete($id)
    {
        try {
            $dbh = $this->conn;

            $dbh->beginTransaction();

            $delete = $dbh->prepare("DELETE FROM `biaya` WHERE `id` = :id");
            $delete->bindParam(":id", $id);
            $delete->execute();

            $errorInfo = $delete->errorInfo();
            if ($errorInfo[0] !== '00000') {
                $dbh->rollBack();
                echo "Error executing query: " . $errorInfo[2];
            } else {
                $dbh->commit();

                $dbh->exec("ALTER TABLE `biaya` AUTO_INCREMENT = 1");

                return $delete->rowCount();
            }
        } catch (\PDOException $e) {
            $dbh->rollBack();
            echo $e->getMessage();
        }
    }

    public function biayaById($id)
    {
        try {
            $dbh = $this->conn;
            $sql = "SELECT * FROM biaya WHERE id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $biaya = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $biaya;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateTotal($data)
    {
        try {
            $dbh = $this->conn;

            // Query untuk menghitung total berdasarkan kd_obat di tabel annual_needs
            $k_total_obat_query = "SELECT SUM(jumlah) AS total FROM annual_needs";

            // Eksekusi query untuk mendapatkan total
            $stmt_total = $dbh->prepare($k_total_obat_query);
            $total_result = $stmt_total->fetch();
            $total = $total_result['total'];

            echo $total;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
