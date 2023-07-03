<?php
namespace app\controllers;

use app\models\{WebApp, User};
use app\helpers\{Helpers};

class UserDataController {


    public $helpers;

    public function __construct()
    {
        session_start();
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

        $rows = $data_model->all("SELECT * FROM `admin` ORDER BY `id` DESC");

        $is_mobile = $helpers->isMobileDevice();

        $partials = $model->getPartials($param['page']);


        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function index($param) 
    {
        if(isset($_SESSION['token'])) {
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
        } else {
            header("Location: /?error=forbaiden", 1);
        }
    }


    public function edit($dataParam)
    {
        echo "Data Param: " . $dataParam;
    }
}
