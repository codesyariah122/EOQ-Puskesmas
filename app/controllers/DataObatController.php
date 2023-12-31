<?php

namespace app\controllers;

use app\models\{DataObat};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class DataObatController
{


    public $helpers, $conn, $obat_model;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->obat_model = new DataObat;
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

        // Query data from database variable ini akan di gunakan untuk input field jenis_obat
        $jenis_obat = ['TABLET', 'CAPSULE', 'SYRUP'];
        $dataEdit = $this->obat_model->obatById($dataParam);

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
        $contents = 'app/views/dashboard/edit/index.php';

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
            $keyword = isset($_GET['keyword']) ? @$_GET['keyword'] : '';
            $page = isset($_GET['page']) ? intval(@$_GET['page']) : 1;
            $offset = ($page - 1) * $limit;

            if (!empty($keyword)) {
                $countPage = $this->obat_model->countSearchData($keyword);
                $totalPage = ceil($countPage / $limit);
                $obats = $this->obat_model->searchData($keyword, $offset, $limit);
            } else {
                $countPage = $this->obat_model->countAllData();
                $totalPage = ceil($countPage / $limit);
                $obats = $this->obat_model->all("SELECT DISTINCT obat.*, stock_opname.sisa_stok, annual_needs.satuan, annual_needs.k_tahun, annual_needs.jumlah FROM obat LEFT JOIN stock_opname ON obat.kd_obat = stock_opname.kd_obat LEFT JOIN annual_needs ON obat.kd_obat = annual_needs.kd_obat ORDER BY obat.id DESC LIMIT $offset, $limit");
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
        try {
            header("Content-Type: application/json");

            $get_obat_max = $this->obat_model->maxKdObat();
            $last_id = $get_obat_max ? $get_obat_max += 1 : 1;
            $last_kdObat = "KO" . $last_id;

            if (empty(@$_POST['nm_obat']) ||  empty(@$_POST['isi']) ||  empty(@$_POST['satuan']) || empty(@$_POST['jenis_obat']) || empty(@$_POST['harga']) || empty(@$_POST['stok'])) {
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
                    'isi' => @$_POST['isi'],
                    'satuan' => @$_POST['satuan'],
                    'jenis_obat' => trim(htmlspecialchars((@$_POST['jenis_obat']))),
                    'harga' => @$_POST['harga'],
                    'stok' => @$_POST['stok']
                ];

                if ($this->obat_model->store($prepareData, $get_obat_max) > 0) {
                    $newObat = $this->obat_model->obatById($last_kdObat);
                    // var_dump($newObat); die;
                    $data = [
                        'success' => true,
                        'message' => "{$newObat['nm_obat']}, berhasil ditambahkan!",
                        'data' => $newObat
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'error' => true,
                        'message' => "Data masih belum lengkap, periksa kembali !"
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
        try {
            header("Content-Type: application/json");

            $prepareData = [
                'kd_obat' => @$_POST['kd_obat'],
                'nm_obat' => @$_POST['nm_obat'],
                'jenis_obat' => @$_POST['jenis_obat'],
                'harga' => @$_POST['harga'],
                'stok' => @$_POST['stok']
            ];

            $obatHasUpdate = $this->obat_model->obatById($dataParam);
            if ($this->obat_model->update($prepareData, $dataParam) === 1) {
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
        } catch (\PDOException $e) {
            $data = [
                'error' => true,
                'message' => "Terjadi kesalahan : " . $e->getMessage()
            ];

            echo json_encode($data);
        }
    }

    public function delete($dataParam)
    {
        try {
            header("Content-Type: application/json");

            if ($this->obat_model->delete($dataParam) === 1) {
                $obatHasUpdate = $this->obat_model->obatById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "Obat with kode : {$dataParam}, berhasil di delete!",
                    'data' => $obatHasUpdate
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
