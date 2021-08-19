<?php

include_once ('./controller/LocalController.php');

class Local extends LocalController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new LocalController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new LocalController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new LocalController();
		$controller->listarTudo($json);
	}
        
	public function localPorSubgrupo($json) {
		$controller = new LocalController();
		$controller->localPorSubgrupo($json);
	}        

	public function remover($json) {
		$controller = new LocalController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new LocalController();
		$controller->update($json);
	}
        
	public function impactoPorPublicoLocal($json) {
		$controller = new LocalController();
		$controller->impactoPorPublicoLocal($json);
	}   
        
	public function impactosPorLocal($json) {
		$controller = new LocalController();
		$controller->impactosPorLocal($json);
	}         
            
}