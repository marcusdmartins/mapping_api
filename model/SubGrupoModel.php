<?php

class SubGrupoModel {

    private $id;
    private $grupo;
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
    
    function getGrupo() {
        return $this->grupo;
    }

    function setGrupo(GrupoModel $grupo) {
        $this->grupo = $grupo;
    }
}