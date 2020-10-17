<?php
class EventosAdmModel extends ItemsAbstract{

    function insere_form()
    {
        return 'insere_evento';
    }

    function table_name()
    {
        return 'eventos';
    }

    function id_table()
    {
        return 'idEvento';
    }

    function url_name()
    {
        return 'evento';
    }

    function haveImage()
    {
        return true;
    }

    /*public function get_assoc_by_id_evento(){
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
    }*/

    /*public function listar_eventos(){
        $id = $where = $query_limit = null;

        if(is_numeric(chk_array($this->parametros, 0))){
            $id = array(chk_array($this->parametros, 0));
            $where = ' WHERE a.idAssoc = ? ';
        }
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;
        $pagina--;
        $posts_por_pagina = $this->posts_por_pagina;
        $offset = $pagina * $posts_por_pagina;
        if(empty($this->sem_limite)){
            $query_limit = " LIMIT $offset, $posts_por_pagina ";
        }
        $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);
        print_r($query->fetchAll());
        $data = $query->fetchAll();
        return $data;
    }*/
    public function listar_eventos(){
        // Configura as variáveis que vamos utilizar
        $id = $where = $query_limit = null;

        // Verifica se um parâmetro foi enviado para carregar uma notícia
        if (is_numeric(chk_array($this->parametros, 0))) {

            // Configura o ID para enviar para a consulta
            $id = array(chk_array($this->parametros, 0));

            // Configura a cláusula where da consulta
            $where = " WHERE a.idAssoc = ? ";
        }

        // Configura a página a ser exibida
        $pagina = !empty($this->parametros[1]) ? $this->parametros[1] : 1;

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
        $query = $this->db->query('SELECT a.idAssoc, e.idAssoc, e.idEvento, k.idEvento, k.titulo, k.evento, k.imagem FROM associacao a INNER JOIN associaeventos e ON a.idAssoc = e.idAssoc INNER JOIN eventos k ON e.idEvento = k.idEvento '.$where.' ORDER BY a.idAssoc DESC '.$query_limit, $id);

        // Retorna
        return $query->fetchAll();
    }

    public function get_eventos_nome(){
        $query = $this->db->query('SELECT * FROM eventos');
        return $query->fetchAll();
    }

    public function insere_evento(){
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_even'])) {
            return;
        }
        if (chk_array($this->parametros, 0) == 'edit') {
            return;
        }

        if (is_numeric(chk_array($this->parametros, 1))) {
            return;
        }
        unset($_POST['insere_even']);
        print_r($_POST);
        $query = $this->db->insert('associaeventos', $_POST);

        if ($query) {
            $this->form_msg = '<p class="success">Evento atualizada com sucesso!</p>';
            return;
        }
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
    }
}
