<?php
namespace app\controllers;

use app\models\{WebApp, DataObat, PengajuanObat};
use app\helpers\{Helpers};

class PengajuanObatController {


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

         // Query data from database
        $limit = 10;
        $page = isset($_GET['page']) ? intval(@$_GET['page']) : 1;
        $offset = ($page - 1) * $limit;
        $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `id` DESC LIMIT $offset, $limit");

        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function index($param) 
    {
        $contents = 'app/views/dashboard/data-obat.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $contents,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];

        // var_dump($param); die;

        $data = [
            'title' => "Aplikasi EOQ - Pengajuan Obat",
            'page' => 'pengajuan-obat',
            'data' => [
                'username' => ucfirst($_SESSION['username']),
                'dataParam' => ''
            ],
        ];

        $this->views($prepare_views, $data);
    }

    public function lists_obat()
    {
        try {
            $limit = 10;
            $keyword = isset($_GET['term']) ? @$_GET['term'] : '';
            $page = isset($_GET['page']) ? intval(@$_GET['page']) : 1;
            $offset = ($page - 1) * $limit;

            if ($keyword) {
                $countPage = $this->data_model->countSearchData($keyword);
                $obats = $this->data_model->searchData($keyword, $offset, $limit);
            } else {
                $countPage = $this->data_model->countAllData();
                $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `id` DESC LIMIT $offset, $limit");
            }

            $totalPage = ceil($countPage / $limit);

            $results = [];

            foreach ($obats as $obat) {
                $results[] = [
                    'id' => $obat['kd_obat'],
                    'text' => $obat['kd_obat'] . ' - ' . $obat['nm_obat']
                ];
            }

            echo json_encode($results);
        } catch (\PDOException $e) {
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : " . $e->getMessage()
            ];

            echo json_encode($data);
        }
    }


    public function edit($dataParam)
    {
    }

    public function all()
    {
    }

    public function store()
    {
        try {
            header("Content-Type: application/json");

            if (empty(@$_POST['kd_obat']) || empty( @$_POST['k_tahun']) || empty(@$_POST['b_simpan']) || empty(@$_POST['b_pesan'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $prepareData = [
                    'kd_obat' => @$_POST['kd_obat'],
                    'k_tahun' => @$_POST['k_tahun'],
                    'b_simpan' => @$_POST['b_simpan'],
                    'b_pesan' => @$_POST['b_pesan']
                ];


                if($this->pengajuan_model->store($prepareData) > 0) {
                    $pengajuanObat = $this->pengajuan_model->pengajuanById(@$_POST['kd_obat']);

                    // var_dump($pengajuanObat);die;

                    $data = [
                        'success' => true,
                        'message' => "Pengajuan baru dengan kode : {$pengajuanObat['kd_obat']}, berhasil ditambahkan!",
                        'data' => $pengajuanObat
                    ];
                    echo json_encode($data);
                }
            }


        } catch (\PDOException $e){
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : ".$e->getMessage()
            ];

            echo json_encode($data);
        }
    }

    public function update($dataParam)
    {
    }

    public function delete($dataParam)
    {
    }
}
