<?php
namespace app\controllers;

use app\models\{WebApp, User};
use app\helpers\{Helpers};

class UserDataController {


    public $helpers, $conn, $data_model;

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
        $this->data_model = new User;
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
        $userData = $this->data_model->userById($dataParam);

        $rows = $this->data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC");

        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function index($param) 
    {
        $contents = 'app/views/dashboard/data-user.php';

        $prepare_views = [
            'header' => 'app/views/layout/dashboard/header.php',
            'contents' => $contents,
            'footer' => 'app/views/layout/dashboard/footer.php',
        ];

        // var_dump($param); die;

        $data = [
            'title' => "Aplikasi EOQ - Data User",
            'page' => 'data-user',
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
            'page' => 'data-user-edit',
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

            $limit = 5;

            if(@$_GET['page']) {
                $countPage = count($this->data_model->all("SELECT * FROM `admin`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $users = $this->data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC LIMIT $limitStart, $limit");
            } elseif (@$_GET['keyword']) {
                $keyword = @$_GET['keyword'];

                $countPage = count($this->data_model->all("SELECT * FROM `admin` WHERE 
                    `kd_admin` LIKE '%$keyword%' OR `nm_lengkap` LIKE '%$keyword' OR `role` LIKE '%$keyword%' ORDER BY `id` DESC"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;

                $users = $this->data_model->searchData($keyword, $limitStart, $limit);
            } else {
                $countPage = count($this->data_model->all("SELECT * FROM `admin`"));
                $totalPage = ceil($countPage / $limit);
                $aktifPage = (is_numeric(@$_GET['page'])) ? intval(@$_GET['page']) : 1;
                $limitStart = ($aktifPage - 1)*$limit;
                $users = $this->data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC LIMIT $limitStart, $limit");
            }


            if (!empty($users)) { 
                $data = [
                    'success' => true,
                    'message' => "Lists of users!",
                    'session_user' => $_SESSION['username'],
                    'data' => $users,
                    'totalData' => count($users),
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

            $last_user = $this->data_model->all("SELECT * FROM admin ORDER BY id DESC LIMIT 1")[0];
            $last_kdAdmin = $last_user['kd_admin'];
            $pattern = "/\d+/";
            preg_match($pattern, $last_kdAdmin, $matches);
            $match_kdAdmin = intval($matches[0]) + 1;
            $kd_admin = "KU0{$match_kdAdmin}";
            $username = $this->helpers->generate_username(@$_POST['nm_lengkap']);
            $check_notlp = $this->helpers->validatePhoneNumber(@$_POST['notlp']);

            

            if (empty(@$_POST['nm_lengkap']) || empty( @$_POST['alamat']) || empty(@$_POST['notlp']) || empty(@$_POST['role'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
                exit();
            } else {
                if(!$check_notlp) {
                    $data = [
                        'error' => true,
                        'message' => "Nomor telphone tidak valid!!"
                    ];

                    echo json_encode($data);
                    exit();
                } else {
                    $notlp = $this->helpers->formatPhoneNumber(@$_POST['notlp']);
                }

                $prepareData = [
                    'kd_admin' => $kd_admin,
                    'nm_lengkap' => ucfirst(@$_POST['nm_lengkap']),
                    'alamat' => trim(htmlspecialchars((@$_POST['alamat']))),
                    'notlp' => $notlp,
                    'username' => $username,
                    'role' => @$_POST['role']
                ];

                if($this->data_model->store($prepareData, $match_kdAdmin) > 0) {
                    $newUser = $this->data_model->userById($kd_admin);
                    $data = [
                        'success' => true,
                        'message' => "{$newUser['nm_lengkap']}, berhasil ditambahkan!",
                        'data' => $newUser
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
            $check_notlp = $this->helpers->validatePhoneNumber(@$_POST['notlp']);

            if(!$check_notlp) {
                $data = [
                    'error' => true,
                    'message' => "Nomor telphone tidak valid!!"
                ];

                echo json_encode($data);
                exit();
            } else {
                $notlp = $this->helpers->formatPhoneNumber(@$_POST['notlp']);
            }

            $prepareData = [
                'kd_admin' => @$_POST['kd_admin'],
                'nm_lengkap' => @$_POST['nm_lengkap'],
                'alamat' => trim(htmlspecialchars(@$_POST['alamat'])),
                'notlp' => $notlp,
                'username' => @$_POST['username']
            ];

            $userHasUpdate = $this->data_model->userById($dataParam);
            if($this->data_model->update($prepareData, $dataParam) === 1) {
                $data = [
                    'success' => true,
                    'message' => "User with kode : {$dataParam}, berhasil di update!",
                    'data' => $userHasUpdate
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'success' => true,
                    'message' => "User with kode : {$dataParam}, tidak ada perubahan data!",
                    'data' => $userHasUpdate
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
                $userHasUpdate = $this->data_model->userById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "User with kode : {$dataParam}, berhasil di delete!",
                    'data' => $userHasUpdate
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
