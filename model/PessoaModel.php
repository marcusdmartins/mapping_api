<?php

class PessoaModel {

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipoUsuario;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setTipoUsuario(TipoUsuarioModel $tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

}