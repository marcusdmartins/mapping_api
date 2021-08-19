<?php

include_once ('./controller/PublicoController.php');

class Publico extends PublicoController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new PublicoController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new PublicoController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new PublicoController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new PublicoController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new PublicoController();
		$controller->update($json);
	}
        
	public function publicoPorCampanha($json) {
		$controller = new PublicoController();
		$controller->publicoPorCampanha($json);
	}   
        
	public function mediaCampanhaPublico($json) {
		$controller = new PublicoController();
		$controller->mediaCampanhaPublico($json);
	}         
            
}