<?php

class SubRotinaModel {

    private $id;
    private $rotina;
    private $nome;
    private $path;
    private $icon;
    private $menu;

    function getId() {
        return $this->id;
    }

    function getRotina() {
        return $this->rotina;
    }

    function getNome() {
        return $this->nome;
    }

    function getPath() {
        return $this->path;
    }

    function getMenu() {
        return $this->menu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRotina(RotinaModel $rotina) {
        $this->rotina = $rotina;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setPath($path) {
        $this->path = $path;
    }

    function setMenu($menu) {
        $this->menu = $menu;
    }
    
    function getIcon() {
        return $this->icon;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

}