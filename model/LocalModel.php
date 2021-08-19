<?php

class LocalModel {

    private $id;
    private $subgrupo;
    private $nome;
    
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
    
    function getSubgrupo() {
        return $this->subgrupo;
    }

    function setSubgrupo(SubGrupoModel $subgrupo) {
        $this->subgrupo = $subgrupo;
    }

}