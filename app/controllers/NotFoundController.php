<?php
// NotFoundController.php
namespace app\controllers;

use app\datasources\WebApp;

class NotFoundController {


    public function views($views, $param)
    {
        $model = new WebApp();
        $data = $model->getData();
        $meta = $model->getMetaTag($param['title']);
        $partials = $model->getPartials($param['page']);
        $page = $param['page'];

        foreach($views as $view):
            require_once $view;
        endforeach;
    }

    public function run() {
        session_start();
        
        // Halaman not found
        header("HTTP/1.0 404 Not Found");
        $views = "app/views/404.php";
        $prepare_views = [
            'header' => 'app/views/layout/app/header.php',
            'home' => $views,
            'footer' => 'app/views/layout/app/footer.php',
        ];

        $data = [
            'title' => "404 Not Found",
            'page' => '404'
        ];

        $this->views($prepare_views, $data);
    }
}
