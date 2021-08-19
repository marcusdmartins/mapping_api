<?php

include_once ('./controller/PublicidadeController.php');

class Publicidade extends PublicidadeController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new PublicidadeController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new PublicidadeController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new PublicidadeController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new PublicidadeController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new PublicidadeController();
		$controller->update($json);
	}
        
	public function buscaPublicidadePorLocal($json) {
		$controller = new PublicidadeController();
		$controller->buscaPublicidadePorLocal($json);
	}

	public function buscaQtdPublicidadePorGrupo($json) {
		$controller = new PublicidadeController();
		$controller->buscaQtdPublicidadePorGrupo($json);
	}

	public function buscaQtdPublicidadePorSubgrupo($json) {
		$controller = new PublicidadeController();
		$controller->buscaQtdPublicidadePorSubgrupo($json);
	}  
        
	public function buscaQtdPublicidadePorLocal($json) {
		$controller = new PublicidadeController();
		$controller->buscaQtdPublicidadesPorLocal($json);
	} 
        
	public function filtroPublicidades($json) {
		$controller = new PublicidadeController();
		$controller->filtroPublicidades($json);
	}
        
	public function buscaPublicidadesPorMidia($json) {
		$controller = new PublicidadeController();
		$controller->buscaPublicidadesPorMidia($json);
	}         
        
	public function buscaPublicidadesPorAmbiente($json) {
		$controller = new PublicidadeController();
		$controller->buscaPublicidadesPorAmbiente($json);
	}               
}