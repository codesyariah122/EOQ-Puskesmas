<?php
namespace app\controllers;

use app\models\{WebApp, DataObat};
use app\helpers\{Helpers};

class DataObatController {


    public $helpers, $conn, $data_model;

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->data_model = new DataObat;
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
        $contents = 'app/views/dashboard/data-obat.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $contents,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];

        // var_dump($param); die;

        $data = [
            'title' => "Aplikasi EOQ - Data Obat",
            'page' => 'data-obat',
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

            $limit = 15;

            if(@$_GET['page']) {
                $countPage = count($this->data_model->all("SELECT * FROM `obat`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `kd_obat` DESC LIMIT $limitStart, $limit");
            } elseif (@$_GET['keyword']) {
                $keyword = @$_GET['keyword'];

                $countPage = count($this->data_model->all("SELECT * FROM `obat` WHERE 
                    `kd_obat` LIKE '%$keyword%' OR `nm_obat` LIKE '%$keyword' 
                    ORDER BY `kd_obat` DESC"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $obats = $this->data_model->searchData($keyword, $limitStart, $limit);
            } else {
                $countPage = count($this->data_model->all("SELECT * FROM `obat`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;
                $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `kd_obat` DESC LIMIT $limitStart, $limit");
            }


            if (!empty($obats)) { 
                $data = [
                    'success' => true,
                    'message' => "Lists of obat!",
                    'session_user' => $_SESSION['username'],
                    'data' => $obats,
                    'totalData' => count($obats),
                    'countPage' => $countPage,
                    'totalPage' => $totalPage,
                    'aktifPage' => $aktifPage
                ];

                echo json_encode($data);
            } else {
                $data = [
                    'empty' => true,
                    'message' => "Data not found !!",
                ];

                echo json_encode($data);
            }

        } catch (\PDOException $e){
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : ".$e->getMessage()
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
}
