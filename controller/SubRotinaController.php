<?php
include_once ('./dao/SubRotinaDAO.php');
include_once ('./model/SubRotinaModel.php');
include_once ('./model/RotinaModel.php');
include_once ('AcessoController.php');


class SubRotinaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $rotina = new RotinaModel();
                $rotina->setId($objData->id_rotina);
                
                $subRotina = new SubRotinaModel();
                $subRotina->setNome($objData->nome);
                $subRotina->setPath($objData->path);
                $subRotina->setIcon($objData->icon);
                $subRotina->setMenu($objData->menu);
                $subRotina->setRotina($rotina);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubRotinaDAO();
                    $dao->save($subRotina);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $rotina = new RotinaModel();
                $rotina->setId($objData->id_rotina);
                
                $subRotina = new SubRotinaModel();
                $subRotina->setId($objData->id);
                $subRotina->setNome($objData->nome);
                $subRotina->setPath($objData->path);
                $subRotina->setIcon($objData->icon);
                $subRotina->setMenu($objData->menu);
                $subRotina->setRotina($rotina);    
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubRotinaDAO();
                    $dao->update($subRotina);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $subRotina = new SubRotinaModel();
                $subRotina->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubRotinaDAO();
                    $dao->view($subRotina);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new SubRotinaDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $subRotina = new SubRotinaModel();
                $subRotina->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubRotinaDAO();
                    $dao->delete($subRotina);
                }
	}
}