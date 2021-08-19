<?php

class ImpactoModel {

    private $id;
    private $local;
    private $publico;
    private $impacto;
    
    function getId() {
        return $this->id;
    }

    function getLocal() {
        return $this->local;
    }

    function getPublico() {
        return $this->publico;
    }

    function getImpacto() {
        return $this->impacto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLocal(LocalModel $local) {
        $this->local = $local;
    }

    function setPublico(PublicoModel $publico) {
        $this->publico = $publico;
    }

    function setImpacto($impacto) {
        $this->impacto = $impacto;
    }

}