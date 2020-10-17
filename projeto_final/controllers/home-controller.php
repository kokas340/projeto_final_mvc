<?
class HomeController extends MainController{
    //carrega a pagina "views/home/home-view.php"
    public function index(){
        //titulo da pagina
        $this->title = 'Home';
        //parametros da funcao
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        //Essa pagina nao precisa de modelo (model)
        /* Carrega os arquivos do view */
        // /views/_includes/header.php
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH.'/views/_includes/menu.php';
        require ABSPATH.'/views/home/home-view.php';
        require ABSPATH.'/views/_includes/footer.php';
    }   
}
?>