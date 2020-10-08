<?php
class AssociacoesAdmModel extends MainModel{
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

    public function listar_assoc(){
        $query = $this->db->query('SELECT * FROM associacao');
        if(!$query){
            $query =  $query->fetchAll();
        }
        return $query;
    }
}
?>