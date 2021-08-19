<?php
include_once ('./dao/LocalDAO.php');
include_once ('./dao/ImpactoDAO.php');
include_once ('./model/LocalModel.php');
include_once ('./model/SubGrupoModel.php');
include_once ('./model/ImpactoModel.php');
include_once ('./model/PublicoModel.php');
include_once ('AcessoController.php');


class LocalController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                $json = Array();
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id_subgrupo);
                
                $impactos = $objData->impacto;
                
                $local = new LocalModel();
                $local->setNome($objData->nome);
                $local->setSubgrupo($subgrupo);
                
                $acessoController = new AcessoController();

                
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new LocalDAO();
                    $daoImpacto = new ImpactoDAO();
                    $result = $dao->save($local);
                    if($result != "error"){
                        $local->setId($result);
                        foreach ($impactos as $impacto){
                            $publico = new PublicoModel();
                            $publico->setId($impacto->publico);
                            $impacto1 = new ImpactoModel();
                            $impacto1->setLocal($local);
                            $impacto1->setPublico($publico);
                            $impacto1->setImpacto($impacto->impacto);
                            $resultImpacto = $daoImpacto->save($impacto1);
                        }
                        
                        if($resultImpacto == "success"){
                                $json = array("codigo" => 0, "message" => "success");
                                header("Content-Type: application/ json");
                                echo json_encode ($json);                                 
                        }else{
                                $json = array("codigo" => 0, "message" => "success");
                                header("Content-Type: application/ json");
                                echo json_encode ($json);                                 
                        }
                    }
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id_subgrupo);
                
                $local = new LocalModel();
                $local->setNome($objData->nome);
                $local->setSubgrupo($subgrupo);
                $local->setId($objData->id);
                $impactos = $objData->impacto;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new LocalDAO();
                    $daoImpacto = new ImpactoDAO();
                    $dao->update($local);
                    
                        //atualiza impactos
                        $daoImpacto->delete($local);
                        foreach ($impactos as $impacto){
                            $publico = new PublicoModel();
                            $publico->setId($impacto->publico);
                            $impacto1 = new ImpactoModel();
                            $impacto1->setLocal($local);
                            $impacto1->setPublico($publico);
                            $impacto1->setImpacto($impacto->impacto);
                            $resultImpacto = $daoImpacto->save($impacto1);
                        }
                        
                        if($resultImpacto == "success"){
                                $json = array("codigo" => 0, "message" => "success");
                                header("Content-Type: application/ json");
                                echo json_encode ($json);                                 
                        }else{
                                $json = array("codigo" => 0, "message" => "success");
                                header("Content-Type: application/ json");
                                echo json_encode ($json);                                 
                        }
                                       
                    
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $local = new LocalModel();
                $local->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new LocalDAO();
                    $dao->view($local);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){             
                    $dao = new LocalDAO();
                    $dao->listAll();
                }
	}
        
	protected function localPorSubgrupo($data) {
		$objData = json_decode($data);
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id_subgrupo);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new LocalDAO();
                    $dao->localPorSubgrupo($subgrupo);
                }
	}        

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $local = new LocalModel();
                $local->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new LocalDAO();
                    $daoImpacto = new ImpactoDAO();
                    
                    $daoImpacto->delete($local);
                    $dao->delete($local);
                }
	}
        
	protected function impactoPorPublicoLocal($data) {
		$objData = json_decode($data);
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $publico = new PublicoModel();
                $publico->setId($objData->id_publico);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new ImpactoDAO();
                    $dao->impactoPorPublicoLocal($publico, $local);
                }
	} 
        
	protected function impactosPorLocal($data) {
		$objData = json_decode($data);
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                 
                    $dao = new ImpactoDAO();
                    $dao->impactosPorLocal($local);
                }
	}         
}