<?php
abstract class ItemsAbstract extends MainModel{
    public $posts_por_pagina = 5;
    public function __construct($db = false, $controller = null){
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }

    public function obter_items() {
        if (chk_array($this->parametros, 0) != 'edit') {
            return;
        }

        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Configura o ID da projeto
        $assoc_id = chk_array($this->parametros, 1);
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST[$this->insere_form()])) {
            unset($_POST[$this->insere_form()]);

            $query = $this->db->update($this->table_name(), $this->id_table(), $assoc_id, $_POST);

            if ($query) {
                $this->form_msg = '<p class="success">projeto atualizado com sucesso!</p>';
            }
        }
        $query = $this->db->query(
            'SELECT * FROM '.$this->table_name().' WHERE '.$this->id_table().' = ? LIMIT 1', array($assoc_id)
        );
        $fetch_data = $query->fetch();

        if (empty($fetch_data)) {
            return;
        }

        $this->form_data = $fetch_data;
    }

    public function listar_items(){
        $id = $where = $query_limit = null;

        if(is_numeric(chk_array($this->parametros, 0))){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE '.$this->id_table().' = ? ';
        }

        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }

        $query = $this->db->query('SELECT * FROM '.$this->table_name().' ' . $where . ' ORDER BY '.$this->id_table().' DESC' . $query_limit, $id);
        return $query->fetchAll();
    }

    public function insere_items(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST[$this->insere_form()])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        if($this->haveImage()){
            $imagem = $this->upload_imagem();
            if (!$imagem) {
                return;
            }
            unset($_POST[$this->insere_form()]);
            // Insere a imagem em $_POST
            $_POST['imagem'] = $imagem;
        }
        $query = $this->db->insert($this->table_name(), $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Noticia atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }

    public function delete_items($parametros = array()){
        //echo chk_array($this->parametros, 3);
        if(chk_array($this->parametros, 3) != 'soc')
            $this->delete_items_not_sepecified();
        else{
            if(chk_array($this->parametros, 1) != 'del')
                return;

            if(!is_numeric(chk_array($this->parametros, 2)))
                return;
            $projeto_id = (int) chk_array($this->parametros, 2);
            //echo $projeto_id;
            $query = $this->db->delete('socios', 'idSocio', $projeto_id);
        }

    }

    public function delete_items_not_sepecified(){
        if(chk_array($this->parametros, 0) != 'del')
            return;

        if(!is_numeric(chk_array($this->parametros, 1)))
            return;

        if(!is_numeric(chk_array($this->parametros, 2)) != 'confirma'){
            $mensagem='<p class="alert">Tem Mesmo certeza que quer apagar o  projeto</p>';
            $mensagem.='<p><a href="'.$_SERVER['REQUEST_URI'] .'/confirma/">Sim</a> |';
            $mensagem .='<a href="'. HOME_URI .'/'.$this->url_name().'/adm">Não</a></p>';
            return $mensagem;
        }

        $projeto_id = (int) chk_array($this->parametros, 1);
        //echo $projeto_id;
        $query = $this->db->delete($this->table_name(), $this->id_table(), $projeto_id);
        //header('http://localhost/projeto_final/associacoes/admassoc');
        //redireciona para a pagina de administrcao de projetos
        echo '<meta http-equiv="Refresh" content="0; url = '.HOME_URI.'/'.$this->url_name().'/adm">';
        echo '<script type="text/javascript">window.location.href = "'.HOME_URI.'/'.$this->url_name().'/adm/" </script>';
    }

    /*public function delete_items() {

        // O parâmetro del deverá ser enviado
        if (chk_array($this->parametros, 0) != 'del') {
            return;
        }

        // O segundo parâmetro deverá ser um ID numérico
        if (!is_numeric(chk_array($this->parametros, 1))) {
            return;
        }

        // Para excluir, o terceiro parâmetro deverá ser "confirma"
        if (chk_array($this->parametros, 2) != 'confirma') {

            // Configura uma mensagem de confirmação para o user
            $mensagem = '<p class="alert">Tem certeza que deseja apagar o projeto?</p>';
            $mensagem .= '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma/">Sim</a> | ';
            $mensagem .= '<a href="' . HOME_URI . '/'.$this->url_name().'/adm/">Não</a></p>';

            // Retorna a mensagem e não excluir
            return $mensagem;
        }

        // Configura o ID da notícia
        $projeto_id = (int) chk_array($this->parametros, 1);

        // Executa a consulta
        $query = $this->db->delete($this->table_name(), $this->id_table(), $projeto_id);

        // Redireciona para a página de administração de projetos
        echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/'.$this->url_name().'/adm">';
        echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/'.$this->url_name().'/adm";</script>';
    }*/


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

    public function get_assoc(){
        $query = $this->db->query('SELECT * FROM associacao');
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

    public function getSociosAssoc($id = 0){
        $query = $this->db->query('SELECT * FROM socios WHERE idAssoc = '.$id);
        return $query->fetchAll();
    }


    abstract function insere_form();

    abstract function table_name();

    abstract function id_table();

    abstract function url_name();

    abstract function haveImage();
}
