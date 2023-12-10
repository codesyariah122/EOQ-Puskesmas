<?php

namespace app\controllers;

use app\models\{DataObat, KebutuhanPertahun, PengajuanObat};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class KebutuhanPertahunController
{


    public $helpers, $conn, $obat_model;
    private $pengajuan_model, $ktahun_model;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->obat_model = new DataObat;
        $this->ktahun_model = new KebutuhanPertahun;
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

        $dataEdit = $this->ktahun_model->kebutuhanById($dataParam);

        // var_dump($dataEdit);

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
            'title' => "Aplikasi EOQ - Kebutuhan Pertahun",
            'page' => 'kebutuhan-pertahun',
            'data' => [
                'username' => ucfirst($_SESSION['username']),
                'dataParam' => ''
            ],
        ];

        $this->views($prepare_views, $data);
    }

    public function lists_data()
    {
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
            'page' => 'kebutuhan-pertahun-edit',
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
                $countPage = $this->ktahun_model->countSearchData($keyword);
                $totalPage = ceil($countPage / $limit);
                $annual = $this->ktahun_model->searchData($keyword, $offset, $limit);
            } else {
                $countPage = $this->ktahun_model->countAllData();
                $totalPage = ceil($countPage / $limit);
                $annual = $this->ktahun_model->all("SELECT obat.id AS obat_id, obat.kd_obat, obat.nm_obat, obat.jenis_obat, obat.harga, obat.stok,
                    annual_needs.id AS needs_id, annual_needs.kd_obat AS needs_kd_obat, annual_needs.k_tahun, annual_needs.satuan, annual_needs.jumlah
                    FROM obat
                    INNER JOIN annual_needs ON obat.kd_obat = annual_needs.kd_obat
                    ORDER BY annual_needs.id DESC
                    LIMIT $limit OFFSET $offset");
            }

            if (!empty($annual)) {
                $data = [
                    'success' => true,
                    'message' => "Lists of kebutuhan pertahun!",
                    'session_user' => $_SESSION['username'],
                    'data' => $annual,
                    'totalData' => count($annual),
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

    public function checkJumlahKebutuhan()
    {
        try {
            $kd_obat = @$_GET['kd_obat'];
            $k_tahun = @$_GET['k_tahun'];
            $data_obat = $this->obat_model->obatById($kd_obat);
            $jumlah = $k_tahun * $data_obat['isi'];
            $data = [
                'success' => true,
                'message' => "Jumlah kebutuhan pertahun!",
                'data' => $jumlah
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

            if (empty(@$_POST['kd_obat']) || empty(@$_POST['k_tahun'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $existingKTahun = $this->ktahun_model->getKebutuhanByKdObat($_POST['kd_obat']);

                if ($existingKTahun) {
                    $data = [
                        'error' => true,
                        'message' => "Data with the same 'kd_obat' already exists."
                    ];

                    echo json_encode($data);
                    return 0;
                }

                $data_obat = $this->obat_model->obatById($_POST['kd_obat']);
                $satuan_obat = $data_obat['satuan'];
                $jumlah = @$_POST['k_tahun'] * $data_obat['isi'];

                $prepareData = [
                    'kd_obat' => @$_POST['kd_obat'],
                    'k_tahun' => @$_POST['k_tahun'],
                    'satuan' => $satuan_obat,
                    'jumlah' => $jumlah
                ];

                if ($this->ktahun_model->store($prepareData) > 0) {
                    $k_obat_tahun = $this->ktahun_model->getKebutuhanByKdObat(@$_POST['kd_obat']);
                    $data = [
                        'success' => true,
                        'message' => "Setup kebutuhan untuk data obat dengan kode : {$k_obat_tahun['kd_obat']}, berhasil ditambahkan!",
                        'data' => $k_obat_tahun
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
                'k_tahun' => @$_POST['k_tahun'],
                'satuan' => @$_POST['satuan'],
                'jumlah' => @$_POST['jumlah']
            ];

            $kTahunHasUpdate = $this->ktahun_model->kebutuhanById($dataParam);
            if ($this->ktahun_model->update($prepareData, $dataParam) === 1) {
                $data = [
                    'success' => true,
                    'message' => "Data with id : {$dataParam}, berhasil di update!",
                    'data' => $kTahunHasUpdate
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'success' => true,
                    'message' => "Data with id : {$dataParam}, tidak ada perubahan data!",
                    'data' => $kTahunHasUpdate
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

            if ($this->ktahun_model->delete($dataParam) === 1) {
                $kebutuhanById = $this->ktahun_model->kebutuhanById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "Kebutuhan pertahun with kode : {$dataParam}, berhasil di delete!",
                    'data' => $kebutuhanById
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
