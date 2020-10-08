<?/*
class UserRegisterModel{
    public $form_data;
    public $form_msg;
    public $db;


    public function __construct($db = false){
        $this->db = $db;
    }

    public function validate_register_form(){
        //configura os dados do formulario
        $this->form_data = array();
        
        //verifica se algo foi passado
        if('POST' === $_SERVER['REQUEST_METHOD'] && !empty($_POST)){
            //faz o loop dos dados do post
            foreach($_POST as $key=>$value){
                //configura os dados do post para a propriedade $form_data
                $this->form_data[$key] = $value;
                //sem campos em branco
                if(empty($value)){
                    //configura mensagem
                    $this->form_msg = '<p class="error">There are empty fields. Data has not been sent</p>';
                    return;
                }
            }
        }else
            //termina se nada foi enviado
            return;           
        
            //veirfifca se a propriedade $form_data foi preenchida
        if(empty($this->form_data))
            return;

        //verifica se o user exsite
        $db_check_user = $this->db->query('SELECT * FROM `users` WHERE `user` = ?', array(chk_array($this->form_data, 'user')));

        //verifica se a consulta foi realizada com sucesso
        if(!$db_check_user){
            $this->form_msg = '<p class?="error">Internal error.</p>';
            return;
        }
        //obtem os dados da base de dados
        $fetch_user = $db_check_user->fetch();  
        $user_id = $fetch_user['user_id'];
        //precisaremos de uma instancia da classe Phpass
        //veja http://www.openwall.com/phpass/
        $password_hash = new PasswordHash(8, FALSE);

        //cria o hash da senha
        $password = $password_hash->HashPassword($this->form_data['user-password']);

        //verifica se as permissions tem valor invalido~
        if(preg_match('/[^0-9A-Za-z\,\.\-\_\s]/is', $this->form_data['user-permissions'])){
            $this->form_msg = '<p class="form_error">Use jusrt letters, numbers and a comma for permissions.</p>';
            return;
        }

        //faz um trim nas permissoes
        $permissions = array_map('trim', explode(',', $this->form_data['user-permissions']));
        $permissions = array_unique($permissions);

        //remove valores em branco
        $permissions = array_filter($permissions);
        //serealizar as permissoes
        $permissions = serialize($permissions);

        //se o id user nao estiver sozinho atualiza os dados
        if(!empty($user_id)){
            $query = $this->db->update('users', 'user_id', $user_id, array('user_password' => $password, 'user_name' => chk_array($this->form_data, 'user_name'), 'user_session_id' => md5(time()), 'user-permissions' => $permissions));
            //verifica se a consulta esta ok e configura a mensagem
            if(!$query){
                $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';
                return;
            }else{
                $this->form_msg = '<p class="form_sucesss">User succefully updated</p>';
                return;
            }
        }else{
            $query = $this->db->insert('users', array('user' => chk_array($this->form_data, 'user'), 'user_password' => $password, 'user_name' => chk_array($this->form_data, 'user_name'), 'user_session_id' => md5(time()), 'user-permissions' => $permissions));
            //veirifca se a consulta esta ok
            if(!$query){
                $this->form_msg = '<p class="form_error">Internal error. Data has not benn sent</p>';
                return;
            }else{  
                $this->form_msg = '<p class="form_sucesss">User succefully inserted</p>';
                return;
            }
        } 
    }
    public function get_register_form($user_id = false){
        //o id de user que vamos pesquisar
        $s_user_id = false;
        //verifica se passou id ao metodo
        if(!empty($user_id)){
            $s_user_id = (int) $user_id;
        }
        //verifica se existe um id de user
        if(empty($s_user_id))
            return;
        
        //verificamos na base de dados
        $query = $this->db->query('SELECT * FROM `users` WHERE `user_id` = ?',array($s_user_id));

        //verifica a consulta
        
    }
}*/
?>
<?php
    class UserRegisterModel{

        public $form_data;
        public $form_msg;
        public $db;

        public function __construct($db = false){
            $this->db = $db;
        }

        public function validate_register_form(){
            //Configura os dados do formulário
            $this->form_data = array();

            //Verifica se algo foi passado
            if('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST)){
                //Faz loop dos dados do post
                foreach($_POST as $key => $value){
                    //Configura os dados do post para a propriedade $form_data
                    $this->form_data[$key] = $value;
                    //Sem campos em branco
                    if(empty($value)){
                         //Configura a mensagem
                        $this->form_msg = '<p class="form_error"> There are empty fields. Data has not been sent.</p>';
                        return;
                    }
                }
            }else{
                //Termina se nada foi enviado
                return;
            }

            //Verifica se a propriedade $form_data foi preenchida
            if(empty($this->form_data)){
                return;
            }

            //Verifica se o user existe
            $db_check_user = $this->db->query('SELECT * FROM `users` WHERE `user` = ?', array(chk_array($this->form_data, 'user')));

            //Verifica se a consulta foi realizado com sucesso
            if(!$db_check_user){
                $this->form_msg = '<p class="form_error"> Internal error.</p>';
                return;
            }

            //Obtém os dados da base de dados
            $fetch_user = $db_check_user->fetch();

            //Configurar o ID do uuser
            $user_id = $fetch_user['user_id'];

            //Precisaremos de uma instância da classe PHPass
            //veja http://www.openwall.com/phpass/
            $password_hash = new PasswordHash(8, FALSE);

            //Cria o hash da senha
            $password = $password_hash->HashPassword($this->form_data['user_password']);

            //Verifica se as permissóes tem algum valor inválido
            if(preg_match('/[^0-9A-Za-z\,\.\-\_\S]/is',$this->form_data['user_permissions'])){
                $this->form_msg = '<p class="form_error"> Use just letters, numbers and a comma for permissions</p>';
                return;
            }

            //Faz um trim nas permissões
            $permissions = array_map('trim',explode(',', $this->form_data['user_permissions']));

            //Remove permissões duplicadas
            $permissions = array_unique($permissions);

            //Remove valores em branco
            $permissions = array_filter($permissions);

            //Serializa as permissões
            $permissions = serialize($permissions);

            //Se o ID do user não estiver vazio, atualiza os dados
            if(!empty($user_id)){
                $query = $this->db->update('users','user_id',$user_id,array(
                    'user_password' => $password, 
                    'user_name' => chk_array($this->form_data, 'user_name'),
                    'user_session_id' => md5(time()),
                    'user_permissions' => $permissions
                    ));

                //Verifica se a consulta está OK e configura a mensagem
                if(!$query){
                    $this->form_msg = '<p class="form_error"> Internal Error. Data has not been sent.</p>';
                    return;
                }else{
                    $this->form_msg = '<p class="form_success"> User successfully updated.</p>';
                    return;
                }

                //Se o ID do user estiver vazio, insere os dados
            }else{
                //Executa a consulta
                $query = $this->db->insert('users', array(
                    'user' => chk_array($this->form_data,'user'),
                    'user_password' => $password, 
                    'user_name' => chk_array($this->form_data,'user_name'),
                    'user_session_id' => md5(time()),
                    'user_permissions' => $permissions
                    ));

                //Verifica se a consulta está OK e configura a mensagem
                if(!$query){
                    $this->form_msg = '<p class="form_error"> Internal Error. Data has not been sent.</p>';
                    return;
                }else{
                    $this->form_msg = '<p class="form_success"> User successfully created.</p>';
                    return;
                }
                
            }
        }

        public function get_register_form($user_id = false){
            //O ID de user que vamos pesquisar
            $s_user_id = false;

            //Verifica se passou ID ao método
            if(!empty($user_id)){
                $s_user_id = (int) $user_id;
            }

            //Verifica se existe um Id de user
            if(empty($s_user_id)){
                return;
            }

            //Verifica na base de dados
            $query = $this->db->query('SELECT * FROM `users` WHERE `user_id` = ?', array($s_user_id));

            //Verifica a consulta
            if(!$query){
                $this->form_msg = '<p class="form_error"> User não existe. </p>';
                return;
            }

            //Obtém os dados da consulta
            $fetch_userdata = $query->fetch();

            //Verifica se os dados da consulta são vazios
            if(empty($fetch_userdata)){
                $this->form_msg = '<p class="form_error"> User do not exists. </p>';
                return;
            }

            //Configura os dados do formulário
            foreach($fetch_userdata as $key => $value){
                $this->form_data[$key] = $value;
            }

            //Por questões de segurança, a senha só poderá ser atualizada
            $this->form_data['user_password'] = null;

            //Remove a serialização das permissões
            $this->form_data['user_permissions'] = unserialize($this->form_data['user_permissions']);

            //Separa as permissões por vírgula
            $this->form_data['user_permissions'] = implode(',', $this->form_data['user_permissions']);
            
        }

        
        public function del_user($parametros = array()){

            //O ID do user
            $user_id = null;

            //Verifica se existe o parâmetro "del" na URL
            if(chk_array($parametros, 0) == 'del'){
                //Monstra uma mensagem de confirmação
                echo '<p class="alert"> Tem certeza que deseja apagar este registo? </p>';
                echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma"> Sim</a> | <a href="' . HOME_URI . '/user-register">Não</a></p>';
                
                //Verifica se o valor do parâmetro é um número
                if(is_numeric(chk_array($parametros, 1)) && chk_array($parametros, 2) == 'confirma'){
                    //Configura o ID do user a ser apagado
                    $user_id = chk_array($parametros, 1);
                }
            }

            //Verifica se o ID não está vazio
            if(!empty($user_id)){
                //O ID precisa ser inteiro
                $user_id = (int) $user_id;

                //Elimina o user
                $query = $this->db->delete('users', 'user_id', $user_id);

                //Redireciona para a página de listagem
                echo '<script type="text/javascript">window.location.href="' . HOME_URI . '/user-register/";</script>';
                return;
            }
        }

        public function get_user_list(){
            //Seleciona os dados da base de dados
            $query = $this->db->query('SELECT * FROM `users` ORDER BY user_id DESC');
            //Verifica se a consulta está OK
            if (!$query){
                return array();
            }
            //Preenche a tabela com os dados do user
            return $query->fetchAll();
        }
    }
?>