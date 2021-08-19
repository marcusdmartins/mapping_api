<?php
include_once ('./dao/CampanhaDAO.php');
include_once ('./model/CampanhaModel.php');
include_once ('./model/PessoaModel.php');
include_once ('./model/PublicoModel.php');
include_once ('AcessoController.php');


class CampanhaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                
                $pessoa = new PessoaModel();
                $pessoa->setId($objData->pessoa_log);
                
                $campanha = new CampanhaModel();
                $campanha->setNome($objData->nome);
                $campanha->setDescricao($objData->descricao);
                $campanha->setAmbiente($objData->ambiente);
                $campanha->setLayout($objData->layout);
                $campanha->setInicio($objData->inicio);
                $campanha->setFim($objData->fim);
                $campanha->setStatus($objData->status);
                $campanha->setPessoa($pessoa);
                $publicos = $objData->publicos;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){   
                    $json = array();
                    $dao = new CampanhaDAO();
                    $result = $dao->save($campanha);
                    if($result != "error"){
                        $campanha->setId($result);
                        foreach ($publicos as $id_pub){
                            $publico = new PublicoModel();
                            $publico->setId($id_pub);
                            $resultPub = $dao->inserePublico($campanha, $publico);
                        }
                        
                        if($resultPub == "success"){
                            $json = array("codigo" => 0, "message" => "success");
                        }else{
                            $json = array("codigo" => 1, "message" => "error");
                        }
                        
                    }else{
                        $json = array("codigo" => 1, "message" => $result);
                    }
                    
                    header("Content-Type: application/json");
                    echo json_encode($json); 
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setNome($objData->nome);
                $campanha->setDescricao($objData->descricao);
                $campanha->setAmbiente($objData->ambiente);
                $campanha->setInicio($objData->inicio);
                $campanha->setFim($objData->fim);
                $campanha->setStatus($objData->status);
                $campanha->setId($objData->id);
                $publicos = $objData->publicos;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $result = $dao->update($campanha);
                    
//                    if($result != "error"){
                        $dao->deletarPublicos($campanha);
                        foreach ($publicos as $id_pub){
                            $publico = new PublicoModel();
                            $publico->setId($id_pub);
                            $resultPub = $dao->inserePublico($campanha, $publico);
                        }
                        
                        if($resultPub == "success"){
                            $json = array("codigo" => 0, "message" => "success");
                        }else{
                            $json = array("codigo" => 1, "message" => "error");
                        }
                        
//                    }else{
//                        $json = array("codigo" => 1, "message" => $result);
//                    }
                    
                    header("Content-Type: application/json");
                    echo json_encode($json);                     
                    
                }
	}  
        
	protected function updateLayout($data) {
		$objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setLayout($objData->layout);
                $campanha->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->updateLayout($campanha);
                }
	}         

	protected function listar($data) {
		$objData = json_decode($data);
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->view($campanha);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){            
                    $dao = new CampanhaDAO();
                    $dao->listAll();
                }
	}
        
	protected function buscaCampanhaInst($data) {
		$objData = json_decode($data);
                $busca = $objData->busca;
                $ambiente = $objData->ambiente;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->buscaCampanhaInst($busca, $ambiente);
                }
	}        

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id);  
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                                
                    $dao = new CampanhaDAO();
                    $dao->deletarPublicos($campanha);
                    $dao->delete($campanha);
                }
	}
        
	protected function validarPublico($data) {
		$objData = json_decode($data);
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                $publico = new PublicoModel();
                $publico->setId($objData->id_publico);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->validaPublicoCampanha($publico, $campanha);
                }
	}
        
	protected function buscaPublicosPorCampanha($data) {
		$objData = json_decode($data);
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->buscaPublicosPorCampanha($campanha);
                }
	}
        
	protected function buscaProximasCampanhas($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->buscaProximasCampanhas();
                }
	} 
        
	protected function buscaCampanhasEmAndamento($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->buscaCampanhasEmAndamento();
                }
	}
        
	protected function custoPorCampanha($data) {
                $objData = json_decode($data);
                $acessoController = new AcessoController();
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->custoPorCampanha($campanha);
                }
	} 
        
	protected function buscaCampanhaPorAmbiente($data) {
		$objData = json_decode($data);
                $ambiente = $objData->ambiente;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                
                    $dao = new CampanhaDAO();
                    $dao->buscaCampanhaPorAmbiente($ambiente);
                }
	}        
}