<?php

include_once ('./controller/CicloController.php');

class Ciclo extends CicloController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new CicloController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new CicloController();
		$controller->listar($json);
	}

	public function listartudo() {
		$controller = new CicloController();
		$controller->listarTudo();
	}

	public function remover($json) {
		$controller = new CicloController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new CicloController();
		$controller->update($json);
	}
            
}