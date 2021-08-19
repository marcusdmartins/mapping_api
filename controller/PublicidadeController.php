<?php
include_once ('./dao/PublicidadeDAO.php');
include_once ('./dao/CicloDAO.php');
include_once ('./model/PublicidadeModel.php');
include_once ('./model/CampanhaModel.php');
include_once ('./model/MidiaModel.php');
include_once ('./model/LocalModel.php');
include_once ('./model/GrupoModel.php');
include_once ('./model/SubgrupoModel.php');
include_once ('./model/PessoaModel.php');
include_once ('./model/CicloModel.php');
include_once('AcessoController.php');


class PublicidadeController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function novo($data) {
		$objData = json_decode($data);
                $dao = new PublicidadeDAO();
                $cicloDao = new CicloDAO();
                
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                
                $midia = new MidiaModel();
                $midia->setId($objData->id_midia);
                
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $pessoa = new PessoaModel();
                $pessoa->setId($objData->pessoa_log);
                
                $ciclo = new CicloModel();
                $ciclo->setInicio($objData->inicio);
                $ciclo->setFim($objData->fim);
                $ciclo->setStatus($objData->status_ciclo);
                $ciclo->setCusto($objData->custo);
                
                $publicidade = new PublicidadeModel();
                $publicidade->setDescricao($objData->descricao);
                $publicidade->setCampanha($campanha);
                $publicidade->setMidia($midia);
                $publicidade->setLocal($local);
                $publicidade->setAmbiente($objData->ambiente);
                $publicidade->setLatitude($objData->latitude);
                $publicidade->setLongitude($objData->longitude);
                $publicidade->setStatus($objData->status);
                $publicidade->setPessoa($pessoa);
                $qtd = $objData->qtd;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    
                    for($i=1; $i <= $qtd; $i++){
                    
                        $resultPub = $dao->save($publicidade);
                        if($resultPub != "error"){
                            $publicidade->setId($resultPub);
                            $ciclo->setPublicidade($publicidade);

                            $resultCiclo = $cicloDao->save($ciclo);
                        }
                    }
                    
                    if($resultCiclo == "success"){
                        $json = array("codigo" => 0, "message" => "success");
                    }else{
                        $json = array("codigo" => 1, "message" => $resultCiclo);
                    }

                    header("Content-Type: application/json");
                    echo json_encode($json);                    
                    
                }
	}
        
	protected function update($data) {
		$objData = json_decode($data);
                
                $campanha = new CampanhaModel();
                $campanha->setId($objData->id_campanha);
                
                $midia = new MidiaModel();
                $midia->setId($objData->id_midia);
                
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $pessoa = new PessoaModel();
                $pessoa->setId($objData->pessoa_log);
                
                $publicidade = new PublicidadeModel();
                $publicidade->setCampanha($campanha);
                $publicidade->setMidia($midia);
                $publicidade->setLocal($local);
                $publicidade->setPessoa($pessoa);
                $publicidade->setDescricao($objData->descricao);
                $publicidade->setLatitude($objData->latitude);
                $publicidade->setLongitude($objData->longitude);
                $publicidade->setStatus($objData->status);
                $publicidade->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->update($publicidade);
                }
	}        

	protected function listar($data) {
		$objData = json_decode($data);
                $publicidade = new PublicidadeModel();
                $publicidade->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->view($publicidade);
                }
	}

	protected function listarTudo($data) {
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PublicidadeDAO();
                    $dao->listAll();
                }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $publicidade = new PublicidadeModel();
                $publicidade->setId($objData->id);                
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->delete($publicidade);
                }
	}
        
	protected function buscaPublicidadePorLocal($data) {
		$objData = json_decode($data);
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscaPublicidadePorLocal($local);
                }
	} 
        
	protected function buscaQtdPublicidadePorGrupo($data){
		$objData = json_decode($data);
                $grupo = new GrupoModel();
                $grupo->setId($objData->id_grupo);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscarPublicidadesPorGrupo($grupo);
                }
	}

	protected function buscaQtdPublicidadePorSubgrupo($data){
		$objData = json_decode($data);
                $subgrupo = new SubGrupoModel();
                $subgrupo->setId($objData->id_subgrupo);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscarPublicidadesPorSubgrupo($subgrupo);
                }
	} 
        
	protected function buscaQtdPublicidadesPorLocal($data){
		$objData = json_decode($data);
                $local = new LocalModel();
                $local->setId($objData->id_local);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscarQtdPublicidadesPorLocal($local);
                }
	}

	protected function filtroPublicidades($data){
		$objData = json_decode($data);
                $campanha = $objData->campanha;
                $midia= $objData->midia;
                $status = $objData->status;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->filtroPublicidades($campanha, $midia, $status);
                }
	}
        
	protected function buscaPublicidadesPorMidia($data){
		$objData = json_decode($data);
                $midia = new MidiaModel();
                $midia->setId($objData->id_midia);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscaPublicidadesPorMidia($midia);
                }
	}
        
	protected function buscaPublicidadesPorAmbiente($data){
		$objData = json_decode($data);
                $ambiente = $objData->ambiente;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                      
                    $dao = new PublicidadeDAO();
                    $dao->buscaPublicidadesPorAmbiente($ambiente);
                }
	}        
}