<?
class AssociacoesController extends MainController{
    /* Carrega a pagina "/views/login/index.php" */

    public function index(){
        $this->title = 'Associacoes';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        //login nao tem model
        /* Carrega os arquivos do view 
        views/_includes/head.php
        */
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/associacoes/assoc_view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        $this->title = 'Associacoes Adm';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        //login nao tem model
        /* Carrega os arquivos do view
        views/_includes/head.php
        */
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/associacoes/assoc-adm-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>