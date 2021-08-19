<?php

class AplicacaoModel {

    private $id;
    private $nome;
    private $token;
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getToken() {
        return $this->token;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setToken($token) {
        $this->token = $token;
    }
    
}
