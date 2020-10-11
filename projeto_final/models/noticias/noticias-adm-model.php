<?php
class NoticiasAdmModel extends MainModel{
    public $posts_por_pagina = 5;
    public function __construct($db = false, $controller = null){
        //config o bd(PDO)
        $this->db = $db;
        //configura o controlador
        $this->controller = $controller;
        //configuramos os parametros
        $this->parametros = $this->controller->parametros;
        //configura os dados do user
        $this->userdata = $this->controller->userdata;
    }

    public function obter_noticas() {
        // Verifica se o primeiro parâmetro é "edit"
        if (chk_array($this->parametros, 0) != 'edit') {
            return;
        }

        // Verifica se o segundo parâmetro é um número
        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Configura o ID da projeto
        $assoc_id = chk_array($this->parametros, 1);

        /*
          Verifica se algo foi enviado e se vem do form que tem o campo
          insere_projeto.

          Se verdadeiro, atualiza os dados conforme a requisição.
         */
        // if 1
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['insere_noticia'])) {
            unset($_POST['insere_noticia']);

            // Atualiza os dados
            $query = $this->db->update('noticias', 'idNoticia', $assoc_id, $_POST);

            // Verifica a consulta
            if ($query) {
                // Retorna uma mensagem
                $this->form_msg = '<p class="success">projeto atualizado com sucesso!</p>';
            }
        }// // end if 1
        // Faz a consulta para obter o valor
        $query = $this->db->query(
            'SELECT * FROM noticias WHERE idNoticia = ? LIMIT 1', array($assoc_id)
        );
        // Obtém os dados
        $fetch_data = $query->fetch();
        // Se os dados estiverem nulos, não faz nada
        if (empty($fetch_data)) {
            return;
        }
        // Configura os dados do formulário
        $this->form_data = $fetch_data;
    }// obtem_projeto

    public function listar_noticias(){
        //configura as variavrid que vamos utilizar
        $id = $where = $query_limit = null;

        //verificamos se um  parametro foi enviado para carregar um projeto
        if(is_numeric(chk_array($this->parametros, 0))){
            //configura o ID para enviar para a consulta
            $id = array(chk_array($this->parametros, 0));
            //configura a clausula where da consulta
            $where = " WHERE idNoticia = ? ";
        }
        //configura a pagina a ser exibida
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        //paginacao incia do 0
        $pagina--;
        //configura o numetro de posts por pagina
        $posts_por_pagina = $this->posts_por_pagina;
        //0 offset dos posts de consulta
        $offset = $pagina * $posts_por_pagina;
        /*
        Esta propriedaxdde foi configurada no noticias-adm-model.php para prevenir limite ou paginacao na administracao */
        if(empty($this->sem_limite)){
            //configura o limite da consulta
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }

        //faz consulta
        $query = $this->db->query('SELECT * FROM noticias ' . $where . ' ORDER BY idNoticia DESC' . $query_limit, $id);
        return $query->fetchAll();
    }

    public function insere_noticias(){
        /*
          Verifica se algo foi passado e se vem do form que tem o campo
          insere_projeto.
         */
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_noticia'])) {
            return;
        }

        /*
          Para evitar conflitos apenas inserimos valores se o parâmetro edit
          não estiver configurado.
         */
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Tenta enviar a imagem
        $imagem = $this->upload_imagem();
        // Verifica se a imagem foi enviada
         if (!$imagem) {
          return;
         }
        // Remove o campo insere_notica para não gerar problema com o PDO
        unset($_POST['insere_noticia']);
        // Insere a imagem em $_POST
        $_POST['imagem'] = $imagem;
        // Configura a data
        /*
        $data = chk_array($_POST, 'dataExec');
        $nova_data = $this->inverte_data($data);*/

        // Adiciona a data no POST
        //$_POST['dataExec'] = $nova_data;

        // Insere os dados na base de dados
        $query = $this->db->insert('noticias', $_POST);

        // Verifica a consulta
        if ($query) {

            // Retorna uma mensagem
            $this->form_msg = '<p class="success">Noticia atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function delete_noticias(){
        //o parametro del devera ser enviado
        if(chk_array($this->parametros, 0) != 'del')
            return;

        //o segundo parametro devera ser um id numerico
        if(!is_numeric(chk_array($this->parametros, 1)))
            return;

        //para excluir o terceiro parametro devera ser "confirma"
        if(!is_numeric(chk_array($this->parametros, 2)) != 'confirma'){
            //configuracao uma mensagem de confirmacao para o user
            $mensagem='<p class="alert">Tem Mesmo certeza que quer apagar o  projeto</p>';
            $mensagem.='<p><a href="'.$_SERVER['REQUEST_URI'] .'/confirma/">Sim</a> |';
            $mensagem .='<a href="'. HOME_URI .'/noticias/adm">Não</a></p>';
            return $mensagem;
        }

        //configura o ID do projeto
        $projeto_id = (int) chk_array($this->parametros, 1);
        //executa a consulta
        $query = $this->db->delete('noticias', 'idNoticia', $projeto_id);
        //redireciona para a pagina de administrcao de projetos
        echo '<meta http-equiv="Refresh" content="0; url = '.HOME_URI.'/noticias/adm">';
        echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/noticias/adm/" </script>';
    }

    public function paginacao(){
    }


    public function upload_imagem(){
        //verifica se o ficheiro da imagem existe
        if(empty($_FILES['projeto_imagem']) && empty($_FILES['imagem'])){
            return;
        }

        //configura os dados da imagem
        $imagem = isset($_FILES['imagem']) ? $_FILES['imagem'] : $_FILES['projeto_imagem'];
        //nome em extenso
        $nome_imagem = strtolower($imagem['name']);
        $ext_imagem = explode('.', $nome_imagem);
        $ext_imagem = end($ext_imagem);
        $nome_imagem = preg_replace('/[^a-zA-Z0-9]/', '', $nome_imagem);
        $nome_imagem .= '_'.mt_rand().'.'.$ext_imagem;

        //tipo nome temporario, erro e tamanho
        $tipo_imagem = $imagem['type'];
        $tmp_imagem = $imagem['tmp_name'];
        $erro_imagem = $imagem['error'];
        $tamanho_imagem = $imagem['size'];

        //os mime type permitidos
        $permitir_tipos = array(
            'imagem/bmp',
            'image/x-windows-bmp',
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png'
        );

        //verifica se o mimetype enviado e permitido
        if(!in_array($tipo_imagem, $permitir_tipos)){
            //retorna uma mensagem
            $this->form_msg = '<p class="error">deve enviar uma imagem nos formatos jpeg, gif, png</p>';
            return;
        }

        //tenta mover o ficheiro enviado
        if(!move_uploaded_file($tmp_imagem, UP_ABSPATH.'/'.$nome_imagem)){
            //retorna uma mensagem
            $this->form_msg = '<p class="error">Erro ao enviar imagem</p>';
            return;
        }

        //retorna o nome da imagem
        return $nome_imagem;
    }



}
?>