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

         // Query data from database
        $jenis_obat = ['TABLET', 'CAPSULE', 'SYRUP'];
        $dataObat = $this->data_model->obatById($dataParam);

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
        $contents = 'app/views/dashboard/edit/data-user.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $contents,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];


        $data = [
            'title' => "Aplikasi EOQ - {$dataParam}",
            'page' => 'data-obat-edit',
            'data' => [
                'username' => ucfirst($_SESSION['username']),
                'dataParam' => $dataParam
            ],
        ];

        $this->views($prepare_views, $data);
    }

    public function all()
    {
        try {
            header("Content-Type: application/json");

            $limit = 10;

            if(@$_GET['page']) {
                $countPage = count($this->data_model->all("SELECT * FROM `obat`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `id` DESC LIMIT $limitStart, $limit");
            } elseif (@$_GET['keyword']) {
                $keyword = @$_GET['keyword'];

                $countPage = count($this->data_model->all("SELECT * FROM `obat` WHERE 
                    `kd_obat` LIKE '%$keyword%' OR `nm_obat` LIKE '%$keyword' OR `jenis_obat` LIKE '%$keyword%' 
                    ORDER BY `id` DESC"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $obats = $this->data_model->searchData($keyword, $limitStart, $limit);
            } else {
                $countPage = count($this->data_model->all("SELECT * FROM `obat`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;
                $obats = $this->data_model->all("SELECT * FROM `obat` ORDER BY `id` DESC LIMIT $limitStart, $limit");
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
        try {
            header("Content-Type: application/json");

            $get_obat_max = $this->data_model->maxKdObat();
            $last_id = $get_obat_max ? $get_obat_max+=1 : 1;
            $last_kdObat = "KO".$last_id;
            if (empty(@$_POST['nm_obat']) || empty( @$_POST['jenis_obat']) || empty(@$_POST['harga']) || empty(@$_POST['stok'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $prepareData = [
                    'kd_obat' => $last_kdObat,
                    'nm_obat' => ucfirst(@$_POST['nm_obat']),
                    'jenis_obat' => trim(htmlspecialchars((@$_POST['jenis_obat']))),
                    'harga' => @$_POST['harga'],
                    'stok' => @$_POST['stok']
                ];


                if($this->data_model->store($prepareData, $get_obat_max) > 0) {
                    $newObat = $this->data_model->obatById($last_kdObat);
                    // var_dump($newObat); die;
                    $data = [
                        'success' => true,
                        'message' => "{$newObat['nm_obat']}, berhasil ditambahkan!",
                        'data' => $newObat
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
        try {
            header("Content-Type: application/json");

            $prepareData = [
                'kd_obat' => @$_POST['kd_obat'],
                'nm_obat' => @$_POST['nm_obat'],
                'jenis_obat' => @$_POST['jenis_obat'],
                'harga' => @$_POST['harga'],
                'stok' => @$_POST['stok']
            ];

            $obatHasUpdate = $this->data_model->obatById($dataParam);
            if($this->data_model->update($prepareData, $dataParam) === 1) {
                $data = [
                    'success' => true,
                    'message' => "Obat with kode : {$dataParam}, berhasil di update!",
                    'data' => $obatHasUpdate
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'success' => true,
                    'message' => "Obat with kode : {$dataParam}, tidak ada perubahan data!",
                    'data' => $obatHasUpdate
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

    public function delete($dataParam)
    {
        try {
            header("Content-Type: application/json");

            if($this->data_model->delete($dataParam) === 1) {
                $obatHasUpdate = $this->data_model->obatById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "Obat with kode : {$dataParam}, berhasil di delete!",
                    'data' => $obatHasUpdate
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
}
