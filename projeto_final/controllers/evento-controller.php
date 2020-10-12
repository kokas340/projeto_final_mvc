<?php
class EventoController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-eventos';
    public function index(){
        $this->title = "Evento";

        $modelo = $this->load_model('eventos/eventos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/eventos/eventos-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function adm(){
        //veirifica se o user esta com sessao ativa/logado
        if(!$this->logged_in){
            //senao garante o logout
            $this->logout();
            //redericiona para a pagina de login
            $this->goto_login();
            //garante que o script nao vai passar daqui
            return;
        }
        //verifica se o user tem a permissao para acessar a esta pagina
        if(!$this->check_permissions($this->permissions_required, $this->userdata['socio_permissions'])){
            //exibe uma mensagem
            echo 'Não tem permissoes para aceder a esta pagina';
            return;
        }
        $this->title = "Eventos ADM";
        $modelo = $this->load_model('eventos/eventos-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/eventos/eventos-adm-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>
