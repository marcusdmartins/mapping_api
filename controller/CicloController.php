<?php
include_once ('./dao/CicloDAO.php');
include_once ('./model/CicloModel.php');
include_once ('./model/PublicidadeModel.php');
include_once ('AcessoController.php');


class CicloController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $publicidade = new PublicidadeModel();
                $publicidade->setId($objData->id_publicidade);
                
                $ciclo = new CicloModel();
                $ciclo->setPublicidade($publicidade);
                $ciclo->setInicio($objData->inicio);
                $ciclo->setFim($objData->fim);
                $ciclo->setCusto($objData->custo);
                $ciclo->setStatus($objData->status);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                                
                    $dao = new CicloDAO();
                    $dao->save($ciclo);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $publicidade = new PublicidadeModel();
                $publicidade->setId($objData->id_publicidade);
                
                $ciclo = new CicloModel();
                $ciclo->setInicio($objData->inicio);
                $ciclo->setFim($objData->fim);
                $ciclo->setCusto($objData->custo);
                $ciclo->setStatus($objData->status);
                $ciclo->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CicloDAO();
                    $dao->update($ciclo);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $ciclo = new CicloModel();
                $ciclo->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CicloDAO();
                    $dao->view($ciclo);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){            
                    $dao = new CicloDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $ciclo = new CicloModel();
                $ciclo->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CicloDAO();
                    $dao->delete($ciclo);
                }
	}
}