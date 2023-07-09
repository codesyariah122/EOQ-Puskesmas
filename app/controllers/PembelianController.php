<?php
namespace app\controllers;

use app\models\{DataObat, Pembelian};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class PembelianController {


    public $helpers, $conn, $obat_model;
    private $pembelian_model;

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->obat_model = new DataObat;
        $this->pembelian_model = new Pembelian;
    }

    public function views($views, $param)
    {
        $helpers = $this->helpers;
        $webApp = new WebApp;
        $data = $webApp->getData();
        $meta = $webApp->getMetaTag($param['title']);
        $welcome_text = "Welcome , {$param['data']['username']}";
        $description = "Sistem Informasi Pengelolaan Pengadaan Obat Balai Kesehatan";
        
        // variable ini digunakan untuk menentukan footer content di homepage jadi jangan di hapus
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
            'title' => "Aplikasi EOQ - Pembelian",
            'page' => 'pembelian',
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
    }

    public function store()
    {
        try {
            header("Content-Type: application/json");

            if (empty(@$_POST['kd_obat']) || empty( @$_POST['jumlah'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $last_id = $this->pembelian_model->lastIdBeli();
                $date = new \DateTime();
                $dataObat = $this->obat_model->obatById(@$_POST['kd_obat']);
                $kode_beli = Helpers::generateRandomString(8);

                $prepareData = [
                    'kd_beli' => $kode_beli,
                    'tgl_beli' => $date->format('Y-m-d, H:i:s'),
                    'kd_obat' => @$_POST['kd_obat'],
                    'jumlah' => @$_POST['jumlah']
                ];


                if($this->pembelian_model->store($prepareData, $last_id !== NULL ? $last_id+=1 : 1) > 0){
                    $pembelian = $this->pembelian_model->pembelianById(@$_POST['kd_obat']);

                    $data = [
                        'success' => true,
                        'message' => "Pembelian baru dengan kode : {$pembelian['kd_beli']}, berhasil ditambahkan!",
                        'data' => $pembelian
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
