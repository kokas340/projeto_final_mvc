<?php
class IteratorList implements IteratorInterface{

    protected $lista = array();
    protected $contador;

    public function __construct($lista){
        $this->lista = $lista;
        $this->contador = 0;
    }

    public function first(){
        $this->contador = 0;
    }

    public function next(){
        $this->contador++;
    }

    public function isDone(){
        return $this->contador == count($this->lista);
    }

    public function currentItem(){
        if($this->isDone()){
            $this->contador = count($this->lista)-1;
        }
        else if($this->contador < 0){
            $this->contador = 0;
        }
        return $this->lista[$this->contador];
    }

}
?>