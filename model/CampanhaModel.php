<?php

class CampanhaModel {

    private $id;
    private $nome;
    private $descricao;
    private $ambiente;
    private $layout;
    private $inicio;
    private $fim;
    private $status;
    private $pessoa;
    private $dataCriacao;
    
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
    
    function getDescricao() {
        return $this->descricao;
    }

    function getLayout() {
        return $this->layout;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFim() {
        return $this->fim;
    }

    function getStatus() {
        return $this->status;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFim($fim) {
        $this->fim = $fim;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setPessoa(PessoaModel $pessoa) {
        $this->pessoa = $pessoa;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }
    
    function getAmbiente() {
        return $this->ambiente;
    }

    function setAmbiente($ambiente) {
        $this->ambiente = $ambiente;
    }

}