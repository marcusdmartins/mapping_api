<?php
include_once ('./dao/PessoaDAO.php');
include_once ('./model/PessoaModel.php');
include_once ('./model/TipoUsuarioModel.php');
include_once ('AcessoController.php');


class PessoaController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function nova($data) {
		$objData = json_decode($data);
                
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->tipoUsuario);
                        
                $pessoa = new PessoaModel();
                $pessoa->setNome($objData->nome);
                $pessoa->setEmail($objData->email);
                $pessoa->setSenha($objData->senha);
                $pessoa->setTipoUsuario($tipoUsuario);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                        
                    $dao = new PessoaDAO();
                    $dao->save($pessoa);
                }
	}
        
	protected function update($data) {
            $objData = json_decode($data);

            $tipoUsuario = new TipoUsuarioModel();
            $tipoUsuario->setId($objData->tipoUsuario);

            $pessoa = new PessoaModel();
            $pessoa->setId($objData->id);
            $pessoa->setNome($objData->nome);
            $pessoa->setEmail($objData->email);
            $pessoa->setTipoUsuario($tipoUsuario);

            $acessoController = new AcessoController();
            if($acessoController->validaToken($data) == "true"){                  
                $dao = new PessoaDAO();
                $dao->update($pessoa);
            }
	}        

	protected function listar($data) {
            $objData = json_decode($data);
            $pessoa = new PessoaModel();
            $pessoa->setId($objData->id);

            $acessoController = new AcessoController();
            if($acessoController->validaToken($data) == "true"){                
                $dao = new PessoaDAO();
                $dao->view($pessoa);
            }
	}

	protected function listarTudo($data) {
            $objData = json_decode($data);
            $acessoController = new AcessoController();
            
            if($acessoController->validaToken($data) == "true"){
                $dao = new PessoaDAO();
                $dao->listAll();
            }
	}

	protected function deletar($data) {
		$objData = json_decode($data);
                
                $pessoa = new PessoaModel();
                $pessoa->setId($objData->id);   
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                        
                    $dao = new PessoaDAO();
                    $dao->delete($pessoa);
                }
	}
        
	protected function buscaPorEmail($data) {
		$objData = json_decode($data);
                $pessoa = new PessoaModel();
                $pessoa->setEmail($objData->email);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                        
                    $dao = new PessoaDAO();
                    $dao->buscaPorEmail($pessoa);
                }
	}     
        
	protected function buscaInstPessoa($data) {
		$objData = json_decode($data);
                
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->tipoUsuario);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->buscaInstPessoa($objData->busca, $tipoUsuario);
                }
	}
        
	protected function listarPorTipo($data) {
		$objData = json_decode($data);
                $tipoUsuario = new TipoUsuarioModel();
                $tipoUsuario->setId($objData->tipoUsuario);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->listarPorTipo($tipoUsuario);
                }
	}    
        
	protected function alteraSenha($data) {
		$objData = json_decode($data);
                $pessoa = new PessoaModel();
                
                $pessoa->setId($objData->id);
                $pessoa->setSenha($objData->senha_antiga);
                $novaSenha = $objData->senha_nova;
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->alteraSenha($pessoa, $novaSenha);
                }
	}
        
	protected function bloquear($data) {
		$objData = json_decode($data);
                $pessoa = new PessoaModel();
                
                $pessoa->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->bloquear($pessoa);
                }
	} 
        
	protected function desbloquear($data) {
		$objData = json_decode($data);
                $pessoa = new PessoaModel();
                
                $pessoa->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->desbloquear($pessoa);
                }
	} 
        
	protected function resetar($data) {
		$objData = json_decode($data);
                $pessoa = new PessoaModel();
                
                $pessoa->setId($objData->id);
                
                $acessoController = new AcessoController();
                if($acessoController->validaToken($data) == "true"){                  
                    $dao = new PessoaDAO();
                    $dao->resetar($pessoa);
                }
	}         
}