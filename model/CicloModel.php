<?php

class CicloModel {

    private $id;
    private $publicidade;
    private $inicio;
    private $fim;
    private $custo;
    private $status;
    
    function getId() {
        return $this->id;
    }

    function getPublicidade() {
        return $this->publicidade;
    }

    function getInicio() {
        return $this->inicio;
    }

    function getFim() {
        return $this->fim;
    }

    function getCusto() {
        return $this->custo;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setPublicidade(PublicidadeModel $publicidade) {
        $this->publicidade = $publicidade;
    }

    function setInicio($inicio) {
        $this->inicio = $inicio;
    }

    function setFim($fim) {
        $this->fim = $fim;
    }

    function setCusto($custo) {
        $this->custo = $custo;
    }

    function setStatus($status) {
        $this->status = $status;
    }
}