<?php
namespace app\controllers;

use app\models\{DataObat, PengajuanObat};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class LaporanEoqController {


    public $helpers, $conn, $data_model;
    private $pengajuan_model;

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->data_model = new DataObat;
        $this->pengajuan_model = new PengajuanObat;
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

        // var_dump($param); die;

        $data = [
            'title' => "Aplikasi EOQ - Laporan EOQ",
            'page' => 'laporan-eoq',
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
                $countPage = $this->pengajuan_model->countSearchData($keyword);
                $totalPage = ceil($countPage / $limit);
                $reports = $this->pengajuan_model->searchData($keyword, $offset, $limit);
            } else {
                $countPage = $this->pengajuan_model->countAllData();
                $totalPage = ceil($countPage / $limit);
                $reports = $this->pengajuan_model->all("SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, eoq.* FROM obat JOIN eoq ON obat.kd_obat = eoq.kd_obat ORDER BY eoq.id DESC LIMIT $offset, $limit");
            }

            if (!empty($reports)) {
                $data = [
                    'success' => true,
                    'message' => "Lists of eoq reports!",
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

            // var_dump($selectedData); die;

            $kd_obat_array = [];
            $eoq_id_array = [];

            foreach ($selectedData as $selected) {
                $kd_obat = $selected['kd_obat'];
                $eoq_id = $selected['id'];
                $kd_obat_array[] = $kd_obat;
                $eoq_id_array[] = $eoq_id;
            }

            $query = "SELECT obat.kd_obat, obat.nm_obat, obat.jenis_obat, eoq.* 
            FROM obat 
            JOIN eoq ON obat.kd_obat = eoq.kd_obat 
            WHERE obat.kd_obat IN (" . implode(",", array_fill(0, count($kd_obat_array), "?")) . ") AND eoq.id IN (" . implode(",", array_fill(0, count($eoq_id_array), "?")) . ")
            ORDER BY eoq.id DESC";

            $results = $this->pengajuan_model->printLaporan($query, $kd_obat_array, $eoq_id_array);

            // var_dump($results); die;

            $data = [
                'success' => true,
                'message' => "Lists of eoq reports!",
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

}
