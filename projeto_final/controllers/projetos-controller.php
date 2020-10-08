<?
class ProjetosController extends MainController{
    public $login_required = false;
    public $permissions_required;
    public $prev_page = false;

    /* Carrega a pagina 
    "/views/projetos/index.php" */

    public function index(){
        $this->title = 'Projetos';
        $modelo = $this->load_model('projetos/projetos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/projetos/projetos-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        $this->title = 'Gerenciar projetos';
        $this->permission_required = 'gerir-projetos';

        //verifica se o user esta logado
        if(!$this->logged_in){
            $this->logout();
            $this->goto_login();
            return;
        }

        //verifica se o user tem permissao para aceder essa pagina
        if(!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])){
            echo 'Não tem permissoes para a esta pagina';
            return;
        }

        //carrega o modelo para aceder este view
        $modelo = $this->load_model('projetos/projetos-adm-model');

        //carrega os arquivos da view
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/projetos/projetos-adm-view.php
        require ABSPATH . '/views/projetos/projetos-adm-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }


    
}
?>