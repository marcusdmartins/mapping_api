<?php

include_once ('./model/TipoUsuarioModel.php');
include_once ('./model/SubRotinaModel.php');
include_once ('./model/RotinaModel.php');
include_once ('./model/PessoaModel.php');
include_once ('./model/AplicacaoModel.php');
include_once ('./dao/AcessoDAO.php');
include_once ('./model/AccessTokenModel.php');
include_once ('./dao/AccessTokenDAO.php');


class AcessoController {

	protected function view($nome) {
		include_once ($nome . '.html');
	}

	protected function getAcessoSistema($data){
            $objData = json_decode($data);

            $pessoa = new PessoaModel();
            $pessoa ->setId($objData->id);

            $dao = new AcessoDAO();
            $dao->pegarAcessos($pessoa);
	}
        
        protected function logar($data){
            $objData = json_decode($data);
            
            $aplicacao = new AplicacaoModel();
            $aplicacao->setToken($objData->token_aplicacao);
            
            $pessoa = new PessoaModel();
            $pessoa->setEmail($objData->email);
            $pessoa->setSenha($objData->senha);
            
            $dao = new AcessoDAO();
            $dao->logar($pessoa, $aplicacao);
        }   
        
        protected function listarPermissoes($data){
            $objData = json_decode($data);
            
            $tipoUsuario = new TipoUsuarioModel();
            $tipoUsuario->setId($objData->tipoUsuario);
            
            $dao = new AcessoDAO();
            $dao->listarPermissoes($tipoUsuario);
        }
        
        protected function listarRotinas(){
            
            $dao = new AcessoDAO();
            $dao->listarRotinas();
        } 
        
        protected function verificaPermissao($data){
            $objData = json_decode($data);
            
            $tipoUsuario = new TipoUsuarioModel();
            $tipoUsuario->setId($objData->tipoUsuario);
            
            $subRotina = new SubRotinaModel();
            $subRotina->setId($objData->subRotina);
            
            $dao = new AcessoDAO();
            $dao->verificaPermissao($tipoUsuario, $subRotina);
        }        

        protected function updatePermissao($data){
            $objData = json_decode($data);
            
            $tipoUsuario = new TipoUsuarioModel();
            $tipoUsuario->setId($objData->tipoUsuario);
            
            $rotina = new RotinaModel();
            $rotina->setId($objData->rotina);            
            
            $subRotina = new SubRotinaModel();
            $subRotina->setId($objData->subRotina);
            
            $dao = new AcessoDAO();
            $dao->updatePermissao($tipoUsuario, $rotina, $subRotina);
        }
        
        public function validaToken($data){
            
            $objData = json_decode($data);
            
            $aplicacao = new AplicacaoModel();
            $aplicacao->setToken($objData->token_aplicacao);
            
            $pessoa = new PessoaModel();
            $pessoa->setId($objData->id_pessoa);
            
            $accessToken = new AccessTokenModel();
            $accessToken->setToken($objData->token);
            $accessToken->setAplicacao($aplicacao);
            $accessToken->setPessoa($pessoa);
            
            $tokenDao = new AccessTokenDAO();
            
            if($tokenDao->validaToken($accessToken) == "true"){
                return "true";
            }else{
                $json = array("login" => "false", "message" => "Nao autorizado");
                header('HTTP/1.1 401 Nao autorizado');
                header('Content-Type: application/json');  
                echo json_encode($json);               
            }           
            
        }
        
}
