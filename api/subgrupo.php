<?php

include_once ('./controller/SubGrupoController.php');

class SubGrupo extends SubGrupoController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new SubGrupoController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new SubGrupoController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new SubGrupoController();
		$controller->listarTudo($json);
	}
        
	public function subgrupoPorGrupo($json) {
		$controller = new SubGrupoController();
		$controller->subgrupoPorGrupo($json);
	}        

	public function remover($json) {
		$controller = new SubGrupoController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new SubGrupoController();
		$controller->update($json);
	}
            
}