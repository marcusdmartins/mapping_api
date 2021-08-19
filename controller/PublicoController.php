<?php
include_once ('./dao/PublicoDAO.php');
include_once ('./model/PublicoModel.php');
include_once ('./model/CampanhaModel.php');
include_once ('AcessoController.php');


class PublicoController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $publico = new PublicoModel();
                $publico->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new PublicoDAO();
                    $dao->save($publico);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $publico = new PublicoModel();
                $publico->setId($objData->id);
                $publico->setNome($objData->nome);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new PublicoDAO();
                    $dao->update($publico);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $publico = new PublicoModel();
                $publico->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new PublicoDAO();
                    $dao->view($publico);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new PublicoDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $publico = new PublicoModel();
                $publico->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                    
                    $dao = new PublicoDAO();
                    $dao->delete($publico);
                }
	}
        
	protected function publicoPorCampanha($data) {
                $objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
            
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new PublicoDAO();
                    $dao->publicoPorCampanha($campanha);
                }
	}  
        
	protected function mediaCampanhaPublico($data) {
                $objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                
                $publico = new PublicoModel();
                $publico->setId($objData->id_publico);
            
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new PublicoDAO();
                    $dao->mediaImpactoCampanha($campanha, $publico);
                }
	}         
}