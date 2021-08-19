<?php

include_once ('./controller/MidiaController.php');

class Midia extends MidiaController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new MidiaController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new MidiaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new MidiaController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new MidiaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new MidiaController();
		$controller->update($json);
	}
        
	public function buscaMidiaPorTipo($json) {
		$controller = new MidiaController();
		$controller->buscaMidiaPorTipo($json);
	}        
            
}