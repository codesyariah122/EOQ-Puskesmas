<?php

namespace app\controllers;

use app\models\{Biaya};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class BiayaController
{
    public $helpers, $conn;
    private $biaya_model;

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->biaya_model = new Biaya;
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

        $dataEdit = $this->biaya_model->biayaById($dataParam);
        // var_dump($dataEdit);
        // die;

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
            'title' => "Aplikasi EOQ - biaya",
            'page' => 'biaya',
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
            'page' => 'biaya-edit',
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
                $countPage = $this->biaya_model->countSearchData($keyword);
                $totalPage = ceil($countPage / $limit);
                $biaya = $this->biaya_model->searchData($keyword, $offset, $limit);
            } else {
                $countPage = $this->biaya_model->countAllData();
                $totalPage = ceil($countPage / $limit);
                $biaya = $this->biaya_model->all("SELECT * FROM `biaya` ORDER BY `id` DESC LIMIT $offset, $limit");
            }

            if (!empty($biaya)) {
                $data = [
                    'success' => true,
                    'message' => "Lists of obat!",
                    'session_user' => $_SESSION['username'],
                    'data' => $biaya,
                    'totalData' => count($biaya),
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

    public function checkTotalBiaya()
    {
        try {
            $nama = @$_GET['nama'];
            $biaya_bln = @$_GET['biaya_bln'];
            $jumlah = @$_GET['jumlah'];
            $jumlah = $biaya_bln * $jumlah;
            $data = [
                'success' => true,
                'message' => "Total biaya {$nama}!",
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

            if (empty(@$_POST['nama']) ||  empty(@$_POST['biaya_bln']) ||  empty(@$_POST['jumlah'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $prepareData = [
                    'nama' => ucfirst(@$_POST['nama']),
                    'biaya_bln' => @$_POST['biaya_bln'],
                    'jumlah' => @$_POST['jumlah'],
                    'total' => @$_POST['total']
                ];

                $existingBiaya = $this->biaya_model->getBiayaByNama($prepareData['nama']);

                if ($existingBiaya) {
                    $data = [
                        'error' => true,
                        'message' => "Data with the same 'nama' already exists."
                    ];

                    echo json_encode($data);
                    return 0;
                }
            
                if ($this->biaya_model->store($prepareData) > 0) {
                    $lastId = $this->biaya_model->lastIdBiaya();
                    $newBiaya = $this->biaya_model->biayaById($lastId);
                    // var_dump($newObat); die;
                    $data = [
                        'success' => true,
                        'message' => "{$newBiaya['nama']}, berhasil ditambahkan!",
                        'data' => $newBiaya
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
                'nama' => @$_POST['nama'],
                'biaya_bln' => @$_POST['biaya_bln'],
                'jumlah' => @$_POST['jumlah'],
                'total' => @$_POST['total']
            ];

            $biayaHasUpdate = $this->biaya_model->biayaById($dataParam);
            if ($this->biaya_model->update($prepareData, $dataParam) === 1) {
                $data = [
                    'success' => true,
                    'message' => "Biaya with id : {$dataParam}, berhasil di update!",
                    'data' => $biayaHasUpdate
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'success' => true,
                    'message' => "Biaya with id : {$dataParam}, tidak ada perubahan data!",
                    'data' => $biayaHasUpdate
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

            if ($this->biaya_model->delete($dataParam) === 1) {
                $biayaHasUpdate = $this->biaya_model->biayaById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "Biaya with id : {$dataParam}, berhasil di delete!",
                    'data' => $biayaHasUpdate
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
