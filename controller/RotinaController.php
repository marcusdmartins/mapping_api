<?php
include_once ('./dao/RotinaDAO.php');
include_once ('./model/RotinaModel.php');
include_once('AcessoController.php');


class RotinaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $rotina = new RotinaModel();
                $rotina->setNome($objData->nome);
                $rotina->setStatus($objData->status);
                $rotina->setIcon($objData->icon);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new RotinaDAO();
                    $dao->save($rotina);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $rotina = new RotinaModel();
                $rotina->setId($objData->id);
                $rotina->setNome($objData->nome);
                $rotina->setStatus($objData->status);
                $rotina->setIcon($objData->icon);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new RotinaDAO();
                    $dao->update($rotina);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $rotina = new RotinaModel();
                $rotina->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new RotinaDAO();
                    $dao->view($rotina);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new RotinaDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $rotina = new RotinaModel();
                $rotina->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new RotinaDAO();
                    $dao->delete($rotina);
                }
	}
}