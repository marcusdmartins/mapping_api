<?php

include_once ('./controller/SubRotinaController.php');

class SubRotina extends SubRotinaController {

	public function index() {
		$this -> view('index');
	}

	public function nova($json) {
		$controller = new SubRotinaController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new SubRotinaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new SubRotinaController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new SubRotinaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new SubRotinaController();
		$controller->update($json);
	}
}