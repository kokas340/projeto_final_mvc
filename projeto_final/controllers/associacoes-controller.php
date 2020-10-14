<?
class AssociacoesController extends MainController{
    /* Carrega a pagina "/views/login/index.php" */
    public $login_required = true;
    public $permissions_required = 'gerir-assoc';
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
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/associacoes/assoc-adm-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function admassoc($parametros){
        $this->title = 'Associacoes Specify Adm';
        //$this->permissions_required = 'gerir-assoc-specify';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        //login nao tem model
        /* Carrega os arquivos do view
        views/_includes/head.php
        */
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
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/associacoes/assoc_adm_specified_view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }

    public function assocquotas(){
        $this->title = 'Quotas';
        //$this->permissions_required = 'gerir-assoc-specify';
        $parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();

        //login nao tem model
        /* Carrega os arquivos do view
        views/_includes/head.php
        */
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
        $modelo = $this->load_model('associacoes/associacoes-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/home/login-view.php
        require ABSPATH . '/views/associacoes/assoc-quotas-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>