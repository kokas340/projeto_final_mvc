<?php
    class SocioRegisterModel{

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
            $db_check_user = $this->db->query('SELECT * FROM `socios` WHERE `login` = ?', array(chk_array($this->form_data, 'login')));

            //Verifica se a consulta foi realizado com sucesso
            if(!$db_check_user){
                $this->form_msg = '<p class="form_error"> Internal error.</p>';
                return;
            }

            //Obtém os dados da base de dados
            $fetch_user = $db_check_user->fetch();

            //Configurar o ID do uuser
            $user_id = $fetch_user['idSocio'];

            //Precisaremos de uma instância da classe PHPass
            //veja http://www.openwall.com/phpass/
            $password_hash = new PasswordHash(8, FALSE);

            //Cria o hash da senha
            $password = $password_hash->HashPassword($this->form_data['password']);
            //Verifica se as permissóes tem algum valor inválido
            if(preg_match('/[^0-9A-Za-z\,\.\-\_\S]/is',$this->form_data['socio_permissions'])){
                $this->form_msg = '<p class="form_error"> Use just letters, numbers and a comma for permissions</p>';
                return;
            }

            //Faz um trim nas permissões
            $permissions = array_map('trim',explode(',', $this->form_data['socio_permissions']));

            //Remove permissões duplicadas
            $permissions = array_unique($permissions);

            //Remove valores em branco
            $permissions = array_filter($permissions);

            //Serializa as permissões
            $permissions = serialize($permissions);

            //Se o ID do user não estiver vazio, atualiza os dados
            if($user_id){
                $query = $this->db->update('socios','idSocio',$user_id,array(
                    'password' => $password,
                    'email' => chk_array($this->form_data, 'email'),
                    'login' => chk_array($this->form_data, 'login'),
                    'nome' => chk_array($this->form_data,'nome'),
                    'socio_session_id' => md5(time()),
                    'socio_permissions' => $permissions,
                    'idAssoc' => chk_array($this->form_data,'idAssoc')
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
                $query = $this->db->insert('socios', array(
                    'login' => chk_array($this->form_data,'login'),
                    'password' => $password,
                    'email' => chk_array($this->form_data, 'email'),
                    'nome' => chk_array($this->form_data,'nome'),
                    'socio_session_id' => md5(time()),
                    'socio_permissions' => $permissions,
                    'idAssoc' => chk_array($this->form_data,'idAssoc')
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
            $query = $this->db->query('SELECT * FROM `socios` WHERE `idSocio` = ?', array($s_user_id));

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
            $this->form_data['password'] = null;

            //Remove a serialização das permissões
            $this->form_data['socio_permissions'] = unserialize($this->form_data['socio_permissions']);

            //Separa as permissões por vírgula
            $this->form_data['socio_permissions'] = implode(',', $this->form_data['socio_permissions']);
            
        }

        
        public function del_user($parametros = array()){

            //O ID do user
            $user_id = null;

            //Verifica se existe o parâmetro "del" na URL
            if(chk_array($parametros, 0) == 'del'){
                //Monstra uma mensagem de confirmação
                echo '<p class="alert"> Tem certeza que deseja apagar este registo? </p>';
                echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma"> Sim</a> | <a href="' . HOME_URI . '/socio-register">Não</a></p>';
                
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
                $query = $this->db->delete('socios', 'idSocio', $user_id);

                //Redireciona para a página de listagem
                echo '<script type="text/javascript">window.location.href="' . HOME_URI . '/socio-register/";</script>';
                return;
            }
        }

        public function get_user_list(){
            //Seleciona os dados da base de dados
            $query = $this->db->query('SELECT * FROM `socios` ORDER BY idSocio DESC');
            //Verifica se a consulta está OK
            if (!$query){
                return array();
            }
            //Preenche a tabela com os dados do user
            return $query->fetchAll();
        }


        public function get_assoc_by_id($id = 0){
            if($id != 0) $query = $this->db->query('SELECT * FROM associacao WHERE idAssoc = '.$id);
            if(!empty($query)) {
                $data = $query->fetch();
                return $data['nome'];
            }
            return "Sem associação";
        }

        public function get_assoc(){
            $query = $this->db->query('SELECT * FROM associacao');
            return $query->fetchAll();
        }

        public function get_soc_by_id($id = 0){
            $query = $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
            return $query->fetch();
        }

        public function getQuotas($id = 0){
            if($id!=0){
                $query = $this->db->query('SELECT * FROM quotas WHERE idSocio = '.$id);
                return $query->fetchAll();
            }
        }

        public function getSocName($id = 0){
            $query =  $this->db->query('SELECT * FROM socios WHERE idSocio = '.$id);
            $data = $query->fetch();
            return $data['nome'];
        }

        public function pay($parametros = array()){

            //O ID do user
            $idQuota = null;

            //Verifica se existe o parâmetro "del" na URL
            if(chk_array($parametros, 1) == 'pay'){
                //Verifica se o valor do parâmetro é um número
                if(is_numeric(chk_array($parametros, 2))){
                    //Configura o ID do user a ser apagado
                    $idQuota = chk_array($parametros, 2);
                }
            }

            //Verifica se o ID não está vazio
            if(!empty($idQuota)){
                //O ID precisa ser inteiro
                $idQuota = (int) $idQuota;

                //Elimina o user
                $query = $this->db->update('quotas', 'idQuota', $idQuota, array("pago" => 1));

                //Redireciona para a página de listagem
                //echo '<script type="text/javascript">window.location.href="' . HOME_URI . '/socio-register/";</script>';
                header('location: '.HOME_URI.'/perfil/me/'.chk_array($parametros, 0));
                return;
            }
        }

        public function listar_eventos($parametros = array()){
            // Configura as variáveis que vamos utilizar
            $id = $where = $query_limit = null;

            // Verifica se um parâmetro foi enviado para carregar uma notícia
            if (is_numeric(chk_array($parametros, 0))) {

                // Configura o ID para enviar para a consulta
                $id = array(chk_array($parametros, 0));

                // Configura a cláusula where da consulta
                $where = " WHERE a.idAssoc = ? ";
            }

            // Configura a página a ser exibida
            $pagina = !empty($parametros[1]) ? $parametros[1] : 1;

            // A páginação inicia do 0
            $pagina--;

            // Configura o número de posts por página
            $posts_por_pagina = $this->posts_por_pagina;

            // O offset dos posts da consulta
            $offset = $pagina * $posts_por_pagina;
            if (empty($this->sem_limite)) {

                // Configura o limite da consulta
                $query_limit = " LIMIT $offset,$posts_por_pagina ";
            }
            /*$query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem, s.idSocio, i.idEvento, i.idSocio FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento INNER JOIN socios s ON s.idSocio = i.idSocio INNER JOIN inscricao i ON i.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);*/
            $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem, s.idAssoc, i.idEvento, i.idSocio FROM socios s INNER JOIN associacao a ON s.idAssoc = a.idAssoc INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento INNER JOIN inscricao i ON k.idEvento = i.idEvento' . $where . ' ORDER BY s.idAssoc DESC ' . $query_limit, $id);

            // Retorna
            return $query->fetchAll();
        }

    }
?>