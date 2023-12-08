<?php

namespace app\models;

use app\config\Database;

class Biaya
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
            $query = "SELECT id FROM biaya ORDER BY id DESC LIMIT 1";
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
            $query = "SELECT COUNT(*) AS total FROM biaya WHERE nama LIKE :keyword";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':keyword', "%$keyword%", \PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (\PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getBiayaByNama($nama)
    {
        try {
            $query = "SELECT * FROM biaya WHERE nama = :nama";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nama', $nama);
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result;
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
            $query = "SELECT * FROM `biaya` WHERE 
			`nama` LIKE :keyword 
			ORDER BY `id` DESC";
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

    public function store($data)
    {
        try {
            $dbh = $this->conn;

            $dbh->beginTransaction();

            $biaya = $dbh->prepare("INSERT INTO biaya (nama, biaya_bln, jumlah, total) VALUES (:nama, :biaya_bln, :jumlah, :total)");
            $biaya->bindParam(':nama', $data['nama']);
            $biaya->bindParam(':biaya_bln', $data['biaya_bln']);
            $biaya->bindParam(':jumlah', $data['jumlah']);
            $biaya->bindParam(':total', $data['total']);
            $biaya->execute();

            $errorInfo = $biaya->errorInfo();
            if ($errorInfo[0] !== '00000') {
                $dbh->rollBack();
                echo "Error executing query: " . $errorInfo[2];
            } else {
                $dbh->commit();

                return $biaya->rowCount();
            }
        } catch (\PDOException $e) {
            $dbh->rollBack();
            echo "Error PDO: " . $e->getMessage();
        } catch (\Exception $e) {
            $dbh->rollBack();
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
}
