<?php
include_once ('./dao/TipoUsuarioDAO.php');
include_once ('./model/TipoUsuarioModel.php');
include_once ('AcessoController.php');


class TipoUsuarioController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {  
		$objData = json_decode($data);
                
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new TipoUsuarioDAO();
                    $dao->save($tipoUsuario);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->id);
                $tipoUsuario->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new TipoUsuarioDAO();
                    $dao->update($tipoUsuario);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new TipoUsuarioDAO();
                    $dao->view($tipoUsuario);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new TipoUsuarioDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {  
		$objData = json_decode($data);
                
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new TipoUsuarioDAO();
                    $dao->delete($tipoUsuario);
                }
	}
}