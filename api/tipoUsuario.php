<?php

include_once ('./controller/TipoUsuarioController.php');

class TipoUsuario extends TipoUsuarioController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new TipoUsuarioController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new TipoUsuarioController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new TipoUsuarioController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new TipoUsuarioController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new TipoUsuarioController();
		$controller->update($json);
	}
            
}