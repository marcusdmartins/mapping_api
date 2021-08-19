<?php

include_once ('./controller/GrupoController.php');

class Grupo extends GrupoController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new GrupoController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new GrupoController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new GrupoController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new GrupoController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new GrupoController();
		$controller->update($json);
	}
            
}