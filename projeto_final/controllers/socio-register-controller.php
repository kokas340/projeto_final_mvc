<?
class SocioRegisterController extends MainController{
    public $login_required = true;
    public $permissions_required = 'gerir-socios';

    //carrega a pagina
    //"/views/user-register/index.php"
    public function index(){
        //page title
        $this->title = 'Socio Register';
        
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

        //parametros da funcao
        $parametros = (func_num_args() >= 1) ? func_get_arg(0) : array();
        //carrega o modelo
        $modelo = $this->load_model('socio-register/socio-register-model');
        //carrega os arquivos do view
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/projetos/projetos-adm-view.php
        require ABSPATH . '/views/socio-register/socio-register-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>