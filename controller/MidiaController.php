<?php
include_once ('./dao/MidiaDAO.php');
include_once ('./model/MidiaModel.php');
include_once ('./model/TipoMidiaModel.php');
include_once ('AcessoController.php');


class MidiaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id_tipomidia);
                
                $midia = new MidiaModel();
                $midia->setNome($objData->nome);
                $midia->setIcon($objData->icon);
                $midia->setTipomidia($tipomidia);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new MidiaDAO();
                    $dao->save($midia);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id_tipomidia);
                
                $midia = new MidiaModel();
                $midia->setId($objData->id);
                $midia->setNome($objData->nome);
                $midia->setIcon($objData->icon);
                $midia->setTipomidia($tipomidia);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new MidiaDAO();
                    $dao->update($midia);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $midia = new MidiaModel();
                $midia->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new MidiaDAO();
                    $dao->view($midia);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new MidiaDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $midia = new MidiaModel();
                $midia->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new MidiaDAO();
                    $dao->delete($midia);
                }
	}
        
	protected function buscaMidiaPorTipo($data) {
		$objData = json_decode($data);
                $tipomidia = new TipoMidiaModel();
                $tipomidia->setId($objData->id_tipomidia);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new MidiaDAO();
                    $dao->buscaMidiaPorTipo($tipomidia);
                }
	}        
}