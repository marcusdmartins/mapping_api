<?php

include_once ('iAccessTokenDAO.php');
include_once ('./model/PessoaModel.php');
include_once ('./model/AplicacaoModel.php');
include_once ('./model/AccessTokenModel.php');

class AccessTokenDAO implements iAccessTokenDAO {
    
    public function save(AccessTokenModel $access_token){
        
        try{
            $sql = "INSERT INTO c_access_token
                        (c_pessoa_id,
                         c_access_token_token,
                         c_aplicacao_id)
                    VALUES 
                        (?,?,?)";
            
            $parametros = array($access_token->getPessoa()->getId(),
                                $access_token->getToken(),
                                $access_token->getAplicacao()->getId());
            
            $rs = ConnectionFactory::getConection()->prepare($sql);
            $rs->execute($parametros);
            
            if($rs->rowCount() > 0){
                return "success";
            }else{
                return "error";
            }
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
    public function listarAplicacoes(){
        $dados = Array();
        try{
            $sql = "SELECT 
                        ap.c_aplicacao_id as id,
                        ap.c_aplicacao_nome as nome,
                        ap.c_aplicacao_token as token
                    FROM c_aplicacao ap";
            
            $rs = ConnectionFactory::getConection()->prepare($sql);
            $rs->execute();
            
            if($rs->rowCount() > 0){
                    while ($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($json, $dados);
                    }
                return $dados;
            }else{
                return "nenhum";
            }
            
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
    public function atualizaToken(PessoaModel $pessoa, AplicacaoModel $aplicacao){
        
        $excl = $this->excluiToken($pessoa, $aplicacao);
        $novoToken = bin2hex(random_bytes(50));
        
        try{
            $sql = "INSERT INTO c_access_token
                    (c_pessoa_id, c_access_token_token, c_aplicacao_token)
                        VALUES
                    (?,?,?)";
            
        $parametros = array($pessoa->getId(),
                            $novoToken,
                            $aplicacao->getToken());
        
        $rs = ConnectionFactory::getConection()->prepare($sql);
        $rs->execute($parametros);
        
        if($rs->rowCount() > 0){
            return $novoToken;
        }else{
            return "error";
        }
            
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
    public function validaToken(AccessTokenModel $access_token){
        try{
            $sql = "SELECT * FROM
                        c_access_token
                    WHERE
                        c_access_token_token = ? AND
                        c_pessoa_id = ? AND
                        c_aplicacao_token = ?";
            
            $parametros = array($access_token->getToken(),
                                $access_token->getPessoa()->getId(),
                                $access_token->getAplicacao()->getToken());
            
            $rs = ConnectionFactory::getConection()->prepare($sql);
            $rs->execute($parametros);
            
            if($rs->rowCount() > 0){
                return "true";
            }else{
                return "false";
            }
            
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
    public function excluiToken(PessoaModel $pessoa, AplicacaoModel $aplicacao){
        try{
            
            $sql = "DELETE FROM 
                        c_access_token
                    WHERE
                        c_pessoa_id = ? AND
                        c_aplicacao_token = ?";

            $parametros = array($pessoa->getId(),
                                $aplicacao->getToken());

            $rs = ConnectionFactory::getConection()->prepare($sql);
            $rs->execute($parametros);

            if($rs->rowCount() > 0){
                return "success";
            }else{
                return "error";
            }
            
        } catch (Exception $e){
            return $e->getMessage();
        }
    }    
}