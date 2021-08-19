<?php
include_once ('./dao/TipoMidiaDAO.php');
include_once ('./model/TipoMidiaModel.php');
include_once ('AcessoController.php');


class TipoMidiaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new TipoMidiaDAO();
                    $dao->save($tipomidia);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id);
                $tipomidia->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new TipoMidiaDAO();
                    $dao->update($tipomidia);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new TipoMidiaDAO();
                    $dao->view($tipomidia);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new TipoMidiaDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new TipoMidiaDAO();
                    $dao->delete($tipomidia);
                }
	}
}