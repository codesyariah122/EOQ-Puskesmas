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

        $userData = $this->data_model->userById($dataParam);

        $rows = $this->data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC");

        $is_mobile = $helpers->isMobileDevice();

        $partials = $webApp->getPartials($param['page']);

        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function index($param) 
    {
        $contents = 'app/views/admin/data-user.php';

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
        $contents = 'app/views/admin/edit/data-user.php';

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
            $users = $this->data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC");

            if(count($users) > 0) {
                $data = [
                    'success' => true,
                    'message' => "Lists of users!",
                    'session_user' => $_SESSION['username'],
                    'data' => $users
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
            $last_user = $this->data_model->all("SELECT * FROM admin ORDER BY id DESC LIMIT 1")[0];
            $last_kdAdmin = $last_user['kd_admin'];
            $pattern = "/\d+/";
            preg_match($pattern, $last_kdAdmin, $matches);
            $match_kdAdmin = intval($matches[0]) + 1;
            $kd_admin = "KU0{$match_kdAdmin}";
            $username = $this->helpers->generate_username(@$_POST['nm_lengkap']);

            $prepareData = [
                'kd_admin' => $kd_admin,
                'nm_lengkap' => @$_POST['nm_lengkap'],
                'alamat' => @$_POST['alamat'],
                'notlp' => @$_POST['notlp'],
                'username' => $username,
                'role' => @$_POST['role']
            ];

            if (empty(@$_POST['nm_lengkap']) || empty( @$_POST['alamat']) || empty(@$_POST['notlp']) || empty(@$_POST['role'])) {
                $data = [
                    'error' => true,
                    'message' => "Data tidak boleh kosong"
                ];

                echo json_encode($data);
            } else {
                if($this->data_model->store($prepareData, $match_kdAdmin) > 0) {
                    $newUser = $this->data_model->userById($kd_admin);
                    $data = [
                        'success' => true,
                        'message' => "Berhasil menambahkan user baru , {$newUser['nm_lengkap']}!",
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
            $prepareData = [
                'kd_admin' => @$_POST['kd_admin'],
                'nm_lengkap' => @$_POST['nm_lengkap'],
                'alamat' => @$_POST['alamat'],
                'notlp' => @$_POST['notlp'],
                'username' => @$_POST['username']
            ];

            if($this->data_model->update($prepareData, $dataParam) === 1) {
                $userHasUpdate = $this->data_model->userById($dataParam);
                $data = [
                    'success' => true,
                    'message' => "User with kode : {$dataParam}, berhasil di update!",
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
