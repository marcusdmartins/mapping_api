<?php

include_once ('./controller/TipoMidiaController.php');

class TipoMidia extends TipoMidiaController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new TipoMidiaController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new TipoMidiaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new TipoMidiaController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new TipoMidiaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new TipoMidiaController();
		$controller->update($json);
	}
            
}