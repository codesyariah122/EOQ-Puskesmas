<?php
namespace app\controllers;

use app\models\{DataObat, Pembelian, LogPembelian};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class LaporanPembelianController {


    public $helpers, $conn;
    private $pembelian_model, $obat_model, $log_pembelian;

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->obat_model = new DataObat;
        $this->pembelian_model = new Pembelian;
        $this->log_pembelian = new LogPembelian;
    }

    public function views($views, $param)
    {
        $helpers = $this->helpers;
        $webApp = new WebApp;
        $data = $webApp->getData();
        $meta = $webApp->getMetaTag($param['title']);
        $welcome_text = "Welcome , {$param['data']['username']}";
        $description = "Sistem Informasi Pengelolaan Pengadaan Obat Balai Kesehatan";
        
        $page = $param['page'];

        $dataParam = $param['data']['dataParam'];

        $is_mobile = $helpers->isMobileDevice();

        $partials = $webApp->getPartials($param['page']);

        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function index($param) 
    {
        $views = 'app/views/dashboard/index.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $views,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];

        $data = [
            'title' => "Aplikasi EOQ - Laporan Pembelian",
            'page' => 'laporan-pembelian',
            'data' => [
                'username' => ucfirst($_SESSION['username']),
                'dataParam' => ''
            ],
        ];

        $this->views($prepare_views, $data);
    }


    public function edit($dataParam)
    {
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

            if (!empty($reports)) {
                $data = [
                    'success' => true,
                    'message' => "Lists of beli reports!",
                    'session_user' => $_SESSION['username'],
                    'data' => $reports,
                    'totalData' => count($reports),
                    'countPage' => $countPage,
                    'totalPage' => $totalPage,
                    'aktifPage' => $page
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

    public function store()
    {
    }

    public function update($dataParam)
    {
    }

    public function delete($dataParam)
    {
    }

    public function print()
    {
        try {
            $selectedData = $_POST['selectedData'];

            $kd_obat_array = [];
            $beli_id_array = [];

            foreach ($selectedData as $selected) {
                $kd_obat = $selected['kd_obat'];
                $beli_id = $selected['id'];
                $kd_obat_array[] = $kd_obat;
                $beli_id_array[] = $beli_id;
            }

            $query = "SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, obat.harga, beli.* 
            FROM obat 
            JOIN beli ON obat.kd_obat = beli.kd_obat 
            WHERE obat.kd_obat IN (" . implode(",", array_fill(0, count($kd_obat_array), "?")) . ") AND beli.id IN (" . implode(",", array_fill(0, count($beli_id_array), "?")) . ")
            ORDER BY beli.id DESC";

            $results = $this->pembelian_model->printLaporan($query, $kd_obat_array, $beli_id_array);


            $data = [
                'success' => true,
                'message' => "Lists pembelian reports!",
                'session_user' => $_SESSION['username'],
                'data' => $results,
            ];

            echo json_encode($data);
        } catch (\PDOException $e) {
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : " . $e->getMessage()
            ];

            echo json_encode($data);
        }
    }

    public function logPembelian()
    {
        try {
            header("Content-Type: application/json");

            $query = "SELECT admin.*, obat.*, log_pembelian.* 
            FROM log_pembelian 
            LEFT JOIN admin ON log_pembelian.kd_admin = admin.kd_admin 
            LEFT JOIN obat ON log_pembelian.kd_obat = obat.kd_obat ORDER by log_pembelian.id DESC";

            $reports = $this->log_pembelian->all($query);

            if (!empty($reports)) {
                $data = [
                    'success' => true,
                    'message' => "Lists of beli reports!",
                    'session_user' => $_SESSION['username'],
                    'data' => $reports
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
}
