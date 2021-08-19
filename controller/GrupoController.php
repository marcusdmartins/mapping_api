<?php
include_once ('./dao/GrupoDAO.php');
include_once ('./model/GrupoModel.php');
include_once ('AcessoController.php');


class GrupoController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new GrupoDAO();
                    $dao->save($grupo);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setId($objData->id);
                $grupo->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new GrupoDAO();
                    $dao->update($grupo);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $grupo = new GrupoModel();
                $grupo->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new GrupoDAO();
                    $dao->view($grupo);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new GrupoDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new GrupoDAO();
                    $dao->delete($grupo);
                }
	}
}