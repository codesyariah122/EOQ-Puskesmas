<?php

namespace app\controllers;

use app\models\{DataObat, PengajuanObat, KebutuhanPertahun, Biaya, StockOpname};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class PengajuanObatController
{


    public $helpers, $conn, $obat_model;
    private $pengajuan_model, $ktahun_model, $biaya_model, $stock_opname;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->obat_model = new DataObat;
        $this->pengajuan_model = new PengajuanObat;
        $this->ktahun_model = new KebutuhanPertahun;
        $this->biaya_model = new Biaya;
        $this->stock_opname = new StockOpname;
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

        foreach ($views as $view) :
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

            // Logika untuk membatasi ke 10 data pertama jika tidak ada kata pencarian
            if ($keyword === '') {
                $countPage = $this->obat_model->countAllData();
                $obats = $this->obat_model->all("SELECT * FROM `obat` ORDER BY `id` DESC LIMIT $limit");
            } else {
                // Logika pencarian jika ada kata pencarian
                $countPage = $this->obat_model->countSearchData($keyword);
                $obats = $this->obat_model->searchData($keyword, $offset, $limit);
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

    public function pengajuanInputFormula()
    {
        try {
            $kd_obat = @$_GET['kd_obat'];
            $biayaListrik = ucfirst('listrik');
            $biayaOngkir = ucfirst('ongkos kirim');
            $ktahun = $this->ktahun_model->kebutuhanByKdObay($kd_obat);

            $allStock = $this->stock_opname->allStockIn() / 12;

            $totalBiayaListrik = $this->biaya_model->getBiayaByNama($biayaListrik)['total'];
            $totalBiayaOngkir = $this->biaya_model->getBiayaByNama($biayaOngkir)['total'];
            $biayaSimpan = round($totalBiayaListrik / $allStock);
            $totalKtahun = $this->ktahun_model->totalJumlahKebutuhanPerTahun();
            $biayaPemesanan = round(($totalBiayaOngkir / $totalKtahun) * $ktahun['jumlah']);

            $data = [
                'success' => true,
                'message' => "Jumlah kebutuhan pertahun!",
                'data' => [
                    'k_tahun' => $ktahun['k_tahun'],
                    'b_simpan' => $biayaSimpan,
                    'b_pesan' => $biayaPemesanan
                ]
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

    public function store()
    {
        try {
            header("Content-Type: application/json");

            if (empty(@$_POST['kd_obat']) || empty(@$_POST['k_tahun']) || empty(@$_POST['b_simpan']) || empty(@$_POST['b_pesan'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $resultIntvalTime = round(sqrt((2 * @$_POST['b_pesan']) / (@$_POST['b_simpan'] * @$_POST['k_tahun'])) * 365);
                $resultEconomics = round(sqrt(2 * (@$_POST['b_pesan'] * @$_POST['k_tahun']) / @$_POST['b_simpan']));

                $prepareData = [
                    'kd_obat' => @$_POST['kd_obat'],
                    'k_tahun' => @$_POST['k_tahun'],
                    'b_simpan' => @$_POST['b_simpan'],
                    'b_pesan' => @$_POST['b_pesan'],
                    'jumlah_eoq' => $resultEconomics,
                    'intval_time' => $resultIntvalTime
                ];


                if ($this->pengajuan_model->store($prepareData) > 0) {
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
        } catch (\PDOException $e) {
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : " . $e->getMessage()
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
