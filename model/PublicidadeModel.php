<?php

class PublicidadeModel {

    private $id;
    private $descricao;
    private $campanha;
    private $midia;
    private $ambiente;
    private $local;
    private $latitude;
    private $longitude;
    private $status;
    private $pessoa;
    private $dataCriacao;

    
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    
    function getCampanha() {
        return $this->campanha;
    }

    function getMidia() {
        return $this->midia;
    }

    function getAmbiente() {
        return $this->ambiente;
    }

    function getLocal() {
        return $this->local;
    }

    function getLatitude() {
        return $this->latitude;
    }

    function getLongitude() {
        return $this->longitude;
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

    function setCampanha(CampanhaModel $campanha) {
        $this->campanha = $campanha;
    }

    function setMidia(MidiaModel $midia) {
        $this->midia = $midia;
    }

    function setAmbiente($ambiente) {
        $this->ambiente = $ambiente;
    }

    function setLocal(LocalModel $local) {
        $this->local = $local;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
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
    
    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}