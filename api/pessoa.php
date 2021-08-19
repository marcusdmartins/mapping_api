<?php

include_once ('./controller/PessoaController.php');

class Pessoa extends PessoaController {

	public function index() {
		$this -> view('index');
	}

	public function nova($json) {
		$controller = new PessoaController();
		$controller->nova($json);
	}

	public function listar($json) {
		$controller = new PessoaController();
		$controller->listar($json);
	}

	public function listartudo($json) {
		$controller = new PessoaController();
		$controller->listarTudo($json);
	}

	public function remover($json) {
		$controller = new PessoaController();
		$controller->deletar($json);
	}

	public function atualizar($json) {
		$controller = new PessoaController();
		$controller->update($json);
	}
        
	public function buscaPorEmail($json) {
		$controller = new PessoaController();
		$controller->buscaPorEmail($json);
	}
        
	public function buscaInstPessoa($json) {
		$controller = new PessoaController();
		$controller->buscaInstPessoa($json);
	}  
        
	public function listarPorTipo($json) {
		$controller = new PessoaController();
		$controller->listarPorTipo($json);
	} 
        
	public function alteraSenha($json) {
		$controller = new PessoaController();
		$controller->alteraSenha($json);
	}    
        
	public function bloquear($json) {
		$controller = new PessoaController();
		$controller->bloquear($json);
	}          

	public function desbloquear($json) {
		$controller = new PessoaController();
		$controller->desbloquear($json);
	}     
        
	public function resetar($json) {
		$controller = new PessoaController();
		$controller->resetar($json);
	}         
        
}