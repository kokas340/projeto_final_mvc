<?
class LoginController extends MainController{
    /* Carrega a pagina "/views/login/index.php" */
    public function index(){
        $this->title = 'Login';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        //login nao tem model
        /* Carrega os arquivos do view 
        views/_includes/head.php
        */
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/login/login-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
    

    public function delete(){
        $this->logout();
        //redireciona para a pagina de login
        $this->goto_login();
    }
}
?>