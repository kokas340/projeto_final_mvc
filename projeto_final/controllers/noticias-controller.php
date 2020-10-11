<?php
class NoticiasController extends MainController{
    public function index(){
        $this->title = "Noticias";

        $modelo = $this->load_model('noticias/noticias-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/noticias/noticias_view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        $this->title = "Noticias ADM";

        $modelo = $this->load_model('noticias/noticias-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/noticias/noticias-adm-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>
