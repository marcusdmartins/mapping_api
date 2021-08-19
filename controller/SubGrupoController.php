<?php
include_once ('./dao/SubGrupoDAO.php');
include_once ('./model/SubGrupoModel.php');
include_once ('./model/GrupoModel.php');
include_once ('AcessoController.php');


class SubGrupoController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setId($objData->id_grupo);
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setNome($objData->nome);
                $subgrupo->setGrupo($grupo);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubGrupoDAO();
                    $dao->save($subgrupo);
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setId($objData->id_grupo);
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setNome($objData->nome);
                $subgrupo->setGrupo($grupo);
                $subgrupo->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubGrupoDAO();
                    $dao->update($subgrupo);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubGrupoDAO();
                    $dao->view($subgrupo);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new SubGrupoDAO();
                    $dao->listAll();
                }
	}
        
	protected function subgrupoPorGrupo($data) {
		$objData = json_decode($data);
                
                $grupo = new GrupoModel();
                $grupo->setId($objData->id_grupo);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubGrupoDAO();
                    $dao->subgrupoPorGrupo($grupo);
                }
	}        

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new SubGrupoDAO();
                    $dao->delete($subgrupo);
                }
	}
}