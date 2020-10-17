<?php
class PerfilController extends MainController{
    public $login_required = true;
    public $permissions_required = 'perfil';


    public function me(){
        $this->title = 'Perfil';
        //login nao tem model
        /* Carrega os arquivos do view
        views/_includes/head.php
        */
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
        print_r($parametros);
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


        $modelo = $this->load_model('socio-register/socio-register-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/perfil/perfil-soc-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
