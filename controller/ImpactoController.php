<?php
include_once ('./dao/ImpactoDAO.php');
include_once ('./model/ImpactoModel.php');
include_once ('./model/SubGrupoModel.php');
include_once ('AcessoController.php');


class ImpactoController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {

	}
        
	protected function update($data) {

	}        

	protected function listar($data) {

	}

	protected function listarTudo($data) {

	}
        
	protected function impactoPorSubgrupo($data) {

	}        

	protected function deletar($data) {

	}
}