<?php

include_once ('./controller/RotinaController.php');

class Rotina extends RotinaController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new RotinaController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new RotinaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new RotinaController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new RotinaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new RotinaController();
		$controller->update($json);
	}
}