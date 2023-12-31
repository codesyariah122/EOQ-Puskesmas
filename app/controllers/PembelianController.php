<?php
namespace app\controllers;

use app\models\{DataObat, Pembelian, LogPembelian, User, StockOpname};
use app\helpers\{Helpers};
use app\datasources\WebApp;

class PembelianController {


    public $helpers, $conn;
    private $pembelian_model, $obat_model, $log_pembelian, $user_model, $stok_opname;

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
        $this->user_model = new User;
        $this->stok_opname = new StockOpname;
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

        $dataEdit = $this->pembelian_model->pembelianById($dataParam);


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
        $contents = 'app/views/dashboard/edit/index.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $contents,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];


        $data = [
            'title' => "Aplikasi EOQ - {$dataParam}",
            'page' => 'data-pembelian-edit',
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
        try {
            header("Content-Type: application/json");

            if (empty(@$_POST['kd_obat']) || empty(@$_POST['jumlah'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                $kd_obat = @$_POST['kd_obat'];
                $jumlah = @$_POST['jumlah'];
                $todayDate = date("Y-m-d");
                // Cek apakah kd_obat sudah ada di database
                $dataObat = $this->pembelian_model->checkReadyStock($kd_obat, $todayDate);
                // var_dump($dataObat); die;
                if ($dataObat) {
                // Jika kd_obat sudah ada, lakukan pembaruan jumlah
                    $update_stok = $dataObat['jumlah'] + $jumlah;

                    $prepareUpdateStok = [
                        'kd_beli' => $dataObat['kd_beli'],
                        'tgl_beli' => $dataObat['tgl_beli'],
                        'kd_obat' => $dataObat['kd_obat'],
                        'jumlah' => $update_stok
                    ];

                    if ($this->pembelian_model->update($prepareUpdateStok, $dataObat['kd_beli']) > 0) {
                        $lastIdBeli = $this->pembelian_model->lastIdBeli();
                        $pembelian = $this->pembelian_model->pembelianByIdData($lastIdBeli);

                        $sisaStok = $update_stok;
                        $dataStok = [
                            'kd_obat' => $kd_obat,
                            'sisa_stok' => $sisaStok
                        ];
                        $storeStok = $this->stok_opname->update($dataStok);

                        $data = [
                            'success' => true,
                            'message' => "Pembelian baru dengan kode : {$pembelian['kd_beli']}, berhasil ditambahkan!",
                            'data' => $pembelian
                        ];
                        echo json_encode($data);
                    }
                } else {
                // Jika kd_obat belum ada, tambahkan data baru ke database
                    $last_id = $this->pembelian_model->lastIdBeli();
                    $date = new \DateTime();
                    $kode_beli = Helpers::generateRandomString(8);

                    $prepareData = [
                        'kd_beli' => $kode_beli,
                        'tgl_beli' => $date->format('Y-m-d, H:i:s'),
                        'kd_obat' => $kd_obat,
                        'jumlah' => $jumlah
                    ];

                    if ($this->pembelian_model->store($prepareData, $last_id !== NULL ? $last_id += 1 : 1) % 2 == 1) {

                        $user_login = $this->user_model->getUserByUsername($_SESSION['username']);

                        $prepareLogBeli = [
                            'kd_admin' => $user_login['kd_admin'],
                            'kd_beli' => $kode_beli,
                            'tgl_beli' => $date->format('Y-m-d, H:i:s'),
                            'kd_obat' => $kd_obat,
                            'jumlah' => $jumlah
                        ];
                        $this->log_pembelian->store($prepareLogBeli, $last_id); 
                        $dataObat = $this->obat_model->obatById($kd_obat);
                        $updateStok =  $dataObat['stok'] + $jumlah;

                        $prepareDataStokObat = [
                            'kd_obat' => $dataObat['kd_obat'],
                            'stok' => $updateStok
                        ];

                        $updateStokObat = $this->obat_model->updateByBeli($prepareDataStokObat);

                        $dataStok = [
                            'kd_obat' => $kd_obat,
                            'sisa_stok' => $updateStok
                        ];
                        $storeStok = $this->stok_opname->store($dataStok);

                        $pembelian = $this->pembelian_model->pembelianById($prepareData['kd_beli']);
                        $data_log = $this->log_pembelian->logPembelianByIdData($pembelian['kd_beli']);

                        $data = [
                            'success' => true,
                            'message' => "Pembelian baru dengan kode : {$pembelian['kd_beli']}, berhasil ditambahkan, data stok obat {$dataObat['nm_obat']} ditambahkan!",
                            'data' => $pembelian,
                            'log_beli' => $data_log
                        ];
                        echo json_encode($data);
                    }
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
                'kd_beli' => $dataParam,
                'kd_obat' => @$_POST['kd_obat'],
                'tgl_beli' => @$_POST['tgl_beli'],
                'jumlah' => @$_POST['jumlah']
            ];

            $dataObat = $this->obat_model->obatById(@$_POST['kd_obat']);
            
            $pembelianHasUpdate = $this->pembelian_model->pembelianById($dataParam);

            if($pembelianHasUpdate['jumlah'] === intval(@$_POST['jumlah'])) {
                $update_stok = $pembelianHasUpdate['jumlah'];
            }

            if(@$_POST['jumlah'] > $pembelianHasUpdate['jumlah']) {
                $update_stok = $dataObat['stok'] + @$_POST['jumlah'];
            } else {
                $update_stok = $dataObat['stok'] - @$_POST['jumlah'];
            }

            $prepareUpdateStok = [
                'kd_obat' => @$_POST['kd_obat'],
                'nm_obat' => $dataObat['nm_obat'],
                'jenis_obat' => $dataObat['jenis_obat'],
                'harga' => $dataObat['harga'],
                'stok' => $update_stok
            ];


            
            if($this->pembelian_model->update($prepareData, $dataParam) % 2 == 1) {
                if($this->obat_model->update($prepareUpdateStok, $prepareUpdateStok['kd_obat']) > 0) { 
                    $data = [
                        'success' => true,
                        'message' => "Pembelian : {$dataParam}, berhasil di update!",
                        'data' => $pembelianHasUpdate
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    'success' => true,
                    'message' => "Pembelian: {$dataParam}, tidak ada perubahan data!",
                    'data' => $pembelianHasUpdate
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

            $pembelianHasUpdate = $this->pembelian_model->pembelianById($dataParam);

            $dataObat = $this->obat_model->obatById($pembelianHasUpdate['kd_obat']);

            $logPembelianPrepare = $this->log_pembelian->delete($pembelianHasUpdate['kd_beli']);

            $update_stok = $dataObat['stok'] - $pembelianHasUpdate['jumlah'];

            $prepareUpdateStok = [
                'kd_obat' => $pembelianHasUpdate['kd_obat'],
                'nm_obat' => $dataObat['nm_obat'],
                'jenis_obat' => $dataObat['jenis_obat'],
                'harga' => $dataObat['harga'],
                'stok' => $update_stok
            ];

            if($this->obat_model->update($prepareUpdateStok, $prepareUpdateStok['kd_obat']) > 0) {
                if($this->pembelian_model->delete($dataParam) % 2 == 1) {
                    $data = [
                        'success' => true,
                        'message' => "Data beli: {$dataParam}, berhasil di delete!",
                        'data' => $pembelianHasUpdate
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    'error' => true,
                    'message' => "Terjadi kesalahan, error update stok obat!"
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
