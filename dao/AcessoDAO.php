<?php

include_once ('iAcessoDAO.php');
include_once ('./model/RotinaModel.php');
include_once ('./model/AccessTokenModel.php');
include_once ('./dao/AccessTokenDAO.php');

class AcessoDAO implements iAcessoDAO {

        public function logar(PessoaModel $pessoa, AplicacaoModel $aplicacao){
            $json = Array();
            
            $aplicacaoValid = $this->validaAplicacao($aplicacao);
            if($aplicacaoValid == "true"){
                try{
                    $sql = "SELECT 
                                p.c_pessoa_id as id, 
                                p.c_pessoa_nome as nome, 
                                p.c_pessoa_email as email, 
                                p.c_tipousuario_id as tipo_usuario,
                                p.c_pessoa_bloq as bloq
                            FROM
                                c_pessoa as p
                            WHERE
                                p.c_pessoa_email = ? AND
                                p.c_pessoa_senha = ?";

                    $parametros = array($pessoa->getEmail(), md5($pessoa->getSenha()));
                    $rs = ConnectionFactory::getConection()->prepare($sql);
                    $rs->execute($parametros);

                    if($rs->rowCount() > 0){
                        
                        $result = $rs->fetch(PDO::FETCH_OBJ);
                        
                        if($result->bloq == "s"){
                            $json = array("login" => "bloq");
                            header('HTTP/1.1 401 Nao autorizado');
                            header('Content-Type: application/json');  
                            echo json_encode($json);                              
                        }else{
                        
                            $pessoa->setId($result->id);

                            //GERA NOVO TOKEN
                            $tokenDao = new AccessTokenDAO();
                            $novoToken = $tokenDao->atualizaToken($pessoa, $aplicacao);                    

                            $json = array("login" => "true", 
                                            "id" => $result->id,
                                            "nome" => $result->nome,
                                            "email" => $result->email,
                                            "tipoUsuario" => $result->tipo_usuario,
                                            "token" => $novoToken);

                            header('HTTP/1.1 200 OK');
                            header('Content-Type: application/json');
                            echo json_encode($json);
                        
                        }

                    }else{
                        $json = array("login" => "false");
                        header('HTTP/1.1 401 Nao autorizado');
                        header('Content-Type: application/json');  
                        echo json_encode($json);  
                    }

                }catch (Exception $e){
                    $json = array("login" => "false", "message" => $e->getMessage());
                    header('HTTP/1.1 401 Não autorizado');
                    header('Content-Type: application/json'); 
                    echo json_encode($json); 
                }
            
            }else{
                $json = array("login" => "false", "message" => "Nao autorizado");
                header('HTTP/1.1 401 Não autorizado');
                header('Content-Type: application/json'); 
                echo json_encode($json);
            }
            
        }
        
        public function listarPermissoes(TipoUsuarioModel $tipoUsuario){
            $json = Array();
            try{
                $sql = "SELECT
                            distinct r.c_rotina_id as id,
                                     r.c_rotina_nome as nome,
                                     r.c_rotina_icon as icon
                        FROM
                            c_acesso a,
                            c_rotina r,
                            c_subrotina sr
                        WHERE
                            a.c_tipousuario_id = ? AND
                            a.c_rotina_id = r.c_rotina_id AND
                            r.c_rotina_id = sr.c_rotina_id AND
                            sr.c_subrotina_menu = 's'
                            ORDER BY r.c_rotina_id ASC"; 
                
                $parametros = array($tipoUsuario->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    
                    foreach ($rs as $dados){
                        $rotina = new RotinaModel();
                        $rotina->setId($dados['id']);
                        array_push($json, array(
                                            "id" => $dados['id'],
                                            "nome" => $dados['nome'],
                                            "icon" => $dados['icon'],
                                            "subRotinas" => $this->getSubRotinas($tipoUsuario, $rotina)
                        ));
                    }
                    
                }else{
                    $json = array("codigo" => 1, "message" => "nenhuma rotina encontrada");
                }

            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header('Content-Type: application/json'); 
            echo json_encode($json); 
        }
        
        public function getSubRotinas(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina){
            $dados = Array();
            try{
                $sql = "select 
                            sr.c_subrotina_id as id,
                            sr.c_subrotina_nome as nome,
                            sr.c_subrotina_path as path
                        from
                            c_acesso a,
                            c_subrotina sr
                        where
                            a.c_tipoUsuario_id = ? and
                            a.c_rotina_id = ? and
                            a.c_subrotina_id = sr.c_subrotina_id and
                            sr.c_subrotina_menu = 's'";
                
                $parametros = array($tipoUsuario->getId(), $rotina->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    foreach ($rs as $dado){
                        array_push($dados, array("id" => $dado['id'], "nome" => $dado['nome'], "path" => $dado['path']));
                    };
                }else{
                    $dados = "nenhum";
                }
                
            } catch (Exception $e){
                $dados = $e->getMessage();
            }
            
            return $dados;
        }
        
        public function listarRotinas(){
            $json = Array();
            try{
                $sql = "SELECT
                            r.c_rotina_id as id,
                            r.c_rotina_nome as nome,
                            r.c_rotina_icon as icon
                        FROM
                            c_rotina r"; 
                
                $parametros = array();
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    
                    foreach ($rs as $dados){
                        $rotina = new RotinaModel();
                        $rotina->setId($dados['id']);
                        array_push($json, array(
                                    "id" => $dados['id'],
                                    "nome" => $dados['nome'],
                                    "icon" => $dados['icon'],
                                    "subRotinas" => $this->getTodasSubRotinas($rotina)
                        ));
                    }
                    
                }else{
                    $json = array("codigo" => 1, "message" => "nenhuma rotina encontrada");
                }

            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header('Content-Type: application/json'); 
            echo json_encode($json); 
        }
        
        public function getTodasSubRotinas(RotinaModel $rotina){
            $dados = Array();
            try{
                $sql = "select 
                            sr.c_subrotina_id as id,
                            sr.c_subrotina_nome as nome,
                            sr.c_subrotina_path as path
                        from
                            c_subrotina sr
                        where
                            sr.c_rotina_id = ?";
                
                $parametros = array($rotina->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    foreach ($rs as $dado){
                        array_push($dados, array("id" => $dado['id'], "nome" => $dado['nome'], "path" => $dado['path']));
                    };
                }else{
                    $dados = "nenhum";
                }
                
            } catch (Exception $e){
                $dados = $e->getMessage();
            }
            
            return $dados;
        }

        public function verificaPermissao(TipoUsuarioModel $tipoUsuario, SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "SELECT
                            a.c_acesso_id as id
                        FROM
                            c_acesso a
                        WHERE
                            a.c_tipousuario_id = ? AND
                            a.c_subrotina_id = ?"; 
                
                $parametros = array($tipoUsuario->getId(), $subRotina->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "true");
                }else{
                    $json = array("codigo" => 1, "message" => "false");
                }

            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header('Content-Type: application/json'); 
            echo json_encode($json); 
        }
        
        public function updatePermissao(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina, SubRotinaModel $subRotina){
            
            $result = $this->verificaPermissaoInterno($tipoUsuario, $subRotina);
            
            if($result == "true"){
                $this->retiraPermissao($tipoUsuario, $subRotina);
            }else{
                $this->inserePermissao($tipoUsuario, $rotina, $subRotina);
            }
        }

        public function inserePermissao(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina, SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "INSERT INTO
                            c_acesso
                        (c_tipousuario_id, c_rotina_id, c_subrotina_id)
                        VALUES
                            (?,?,?)"; 
                
                $parametros = array($tipoUsuario->getId(), $rotina->getId(), $subRotina->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "success");
                }else{
                    $json = array("codigo" => 1, "message" => "error");
                }

            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header('Content-Type: application/json'); 
            echo json_encode($json); 
        }
        
        public function retiraPermissao(TipoUsuarioModel $tipoUsuario, SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "DELETE FROM
                            c_acesso
                        WHERE
                            c_tipousuario_id = ? AND
                            c_subrotina_id = ?"; 
                
                $parametros = array($tipoUsuario->getId(), $subRotina->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "success");
                }else{
                    $json = array("codigo" => 1, "message" => "error");
                }

            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header('Content-Type: application/json'); 
            echo json_encode($json); 
        }

        private function verificaPermissaoInterno(TipoUsuarioModel $tipoUsuario, SubRotinaModel $subRotina){
            try{
                $sql = "SELECT
                            a.c_acesso_id as id
                        FROM
                            c_acesso a
                        WHERE
                            a.c_tipousuario_id = ? AND
                            a.c_subrotina_id = ?"; 
                
                $parametros = array($tipoUsuario->getId(), $subRotina->getId());
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

        public function validaAplicacao(AplicacaoModel $aplicacao){
            try{
                $sql = "SELECT * FROM 
                            c_aplicacao a
                        WHERE
                            a.c_aplicacao_token = ?";
                
                $parametros = array($aplicacao->getToken());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    return "true";
                }else{
                    return "false";
                }
                
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
        
}