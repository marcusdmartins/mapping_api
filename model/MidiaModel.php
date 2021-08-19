<?php

class MidiaModel {

    private $id;
    private $nome;
    private $icon;
    private $tipomidia;
            
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
    
    function getIcon() {
        return $this->icon;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }
    
    function getTipomidia() {
        return $this->tipomidia;
    }

    function setTipomidia(TipoMidiaModel $tipomidia) {
        $this->tipomidia = $tipomidia;
    }

}