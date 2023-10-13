<?php
namespace app\controllers;

use app\models\{Pembelian};

class ChartLaporanBeliController {
	
	private $pembelian_model;

	public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->pembelian_model = new Pembelian;
    }

	public function all()
	{
		try {
			header("Content-Type: application/json");

			$limit = 10;
			$keyword = isset($_GET['keyword']) ? @$_GET['keyword'] : '';
			$page = isset($_GET['page']) ? intval(@$_GET['page']) : 1;
			$offset = ($page - 1) * $limit;

			if (!empty($keyword)) {
				$countPage = $this->pembelian_model->countSearchData($keyword);
				$totalPage = ceil($countPage / $limit);
				$reports = $this->pembelian_model->searchData($keyword, $offset, $limit);
			} else {
				$countPage = $this->pembelian_model->countAllData();
				$totalPage = ceil($countPage / $limit);
				$reports = $this->pembelian_model->all("SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, obat.harga, beli.* FROM obat JOIN beli ON obat.kd_obat = beli.kd_obat ORDER BY beli.id DESC LIMIT $offset, $limit");
			}

			$monthlyData = $this->calculateMonthlyData($reports);

			if (!empty($monthlyData)) {
				$data = [
					'success' => true,
					'message' => "Lists of beli reports!",
					'session_user' => $_SESSION['username'],
					'data' => $reports,
					'totalData' => count($reports),
					'countPage' => $countPage,
					'totalPage' => $totalPage,
					'aktifPage' => $page,
					'monthlyData' => $monthlyData,
				];

				echo json_encode($data);
			} else {
				$data = [
					'empty' => true,
					'message' => "Data not found !!",
				];

				echo json_encode($data);
			}
		} catch (\PDOException $e) {
			$data = [
				'error' => true,
				'message' => "Terjadi kesalahan : " . $e->getMessage()
			];

			echo json_encode($data);
		}
	}

	private function calculateMonthlyData($reports)
	{
		$monthlyData = [];

		foreach ($reports as $report) {
			$purchaseDate = date('M Y', strtotime($report['tgl_beli']));

			if (!isset($monthlyData[$purchaseDate])) {
				$monthlyData[$purchaseDate] = 0;
			}

			$monthlyData[$purchaseDate] += $report['jumlah'];
		}

		return $monthlyData;
	}
}