<?php
namespace app\controllers;

use app\models\{WebApp, User};
use app\helpers\{Helpers};

class UserDataController {


    public $helpers, $conn;

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['token'])) {
            header("Location: /?error=forbaiden", 1);
        }

        $this->helpers = new Helpers;
    }

    public function views($views, $param)
    {
        $helpers = $this->helpers;
        $model = new WebApp;
        $data_model = new User;
        $data = $model->getData();
        $meta = $model->getMetaTag($param['title']);
        $welcome_text = "Welcome , {$param['data']['username']}";
        $description = "Sistem Informasi Pengelolaan Pengadaan Obat Balai Kesehatan";
        
        $page = $param['page'];

        $dataParam = $param['data']['dataParam'];

        $rows = $data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC");

        $userData = $data_model->userById($dataParam);

        $is_mobile = $helpers->isMobileDevice();

        $partials = $model->getPartials($param['page']);


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


        $data = [
            'title' => "Aplikasi EOQ - {$param}",
            'page' => $param,
            'data' => [
                'username' => ucfirst($_SESSION['username'])
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

            $updateUser = new User;

            if($updateUser->update($prepareData, $dataParam) === 1) {
                $userHasUpdate = $updateUser->userById($dataParam);
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
}
