<?php

include_once ('./controller/CampanhaController.php');

class Campanha extends CampanhaController {

	public function index() {
		$this -> view('index');
	}

	public function novo($json) {
		$controller = new CampanhaController();
		$controller->novo($json);
	}

	public function listar($json) {
		$controller = new CampanhaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new CampanhaController();
		$controller->listarTudo($json);
	}
        
	public function buscaCampanhaInst($json) {
		$controller = new CampanhaController();
		$controller->buscaCampanhaInst($json);
	}        

	public function remover($json) {
		$controller = new CampanhaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new CampanhaController();
		$controller->update($json);
	}
        
	public function updateLayout($json) {
		$controller = new CampanhaController();
		$controller->updateLayout($json);
	}    
        
	public function validarPublico($json) {
		$controller = new CampanhaController();
		$controller->validarPublico($json);
	}     
        
	public function buscaPublicosPorCampanha($json) {
		$controller = new CampanhaController();
		$controller->buscaPublicosPorCampanha($json);
	}  
        
	public function buscaProximasCampanhas($json) {
		$controller = new CampanhaController();
		$controller->buscaProximasCampanhas($json);
	}    
        
	public function buscaCampanhasEmAndamento($json) {
		$controller = new CampanhaController();
		$controller->buscaCampanhasEmAndamento($json);
	}       
        
	public function custoPorCampanha($json) {
		$controller = new CampanhaController();
		$controller->custoPorCampanha($json);
	} 
        
	public function buscaCampanhaPorAmbiente($json) {
		$controller = new CampanhaController();
		$controller->buscaCampanhaPorAmbiente($json);
	}        
            
}