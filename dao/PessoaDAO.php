<?php

include_once ('./dao/iPessoaDAO.php');

class PessoaDAO implements iPessoaDAO {

	public function save(PessoaModel $pessoa){
            $json = Array();
            try{
                $sql = "INSERT INTO c_pessoa
                               (c_pessoa_nome,
                                c_pessoa_email, 
                                c_pessoa_senha,
                                c_tipousuario_id)
                            VALUES
                                (?,?,?,?)";
                
                $parametros = array($pessoa->getNome(),
                                    $pessoa->getEmail(),
                                    md5($pessoa->getSenha()),
                                    $pessoa->getTipoUsuario()->getId());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $pessoa_nova = $this->pessoaUltimoResgistro();
                    $json = array("codigo" => 0, "message" => "success", "id" => $pessoa_nova->getId());
                }else{
                    $json = array("codigo" => 1, "message" => "error");
                }
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
	}
        
	public function update(PessoaModel $pessoa){
            
            $json = Array();
            try{
                $sql = "UPDATE c_pessoa
                        SET
                            c_pessoa_nome = ?,
                            c_pessoa_email = ?,
                            c_tipousuario_id = ?
                        WHERE 
                            c_pessoa_id = ?";
                
                $parametros = array($pessoa->getNome(),
                                    $pessoa->getEmail(),
                                    $pessoa->getTipoUsuario()->getId(),
                                    $pessoa->getId());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "success");
                }else{
                    $json = array("codigo" => 1, "message" => "error");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}        

	public function view(PessoaModel $pessoa){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_pessoa_id as id, 
                            p.c_pessoa_nome as nome,
                            p.c_pessoa_email as email,
                            p.c_tipousuario_id as tipo_usuario,
                            tu.c_tipousuario_nome as tipo_usuario_nome,
                            p.c_pessoa_bloq as bloq
                        FROM 
                            c_pessoa as p,
                            c_tipousuario tu
                        WHERE
                            p.c_tipousuario_id = tu.c_tipousuario_id AND
                            p.c_pessoa_id = ?";
                
                $parametros = array($pessoa->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = $rs->fetch(PDO::FETCH_OBJ);
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);
	}

	public function listAll(){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_pessoa_id as id, 
                            p.c_pessoa_nome as nome,
                            p.c_pessoa_email as email,
                            p.c_tipousuario_id as tipo_usuario,
                            tu.c_tipousuario_nome as tipo_usuario_nome,
                            p.c_pessoa_bloq as bloq
                        FROM 
                            c_pessoa as p,
                            c_tipousuario tu
                        WHERE
                            p.c_tipousuario_id = tu.c_tipousuario_id";
                
                $parametros = array();
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while ($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($json, $dados);
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);            
	}

	public function delete(PessoaModel $pessoa){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_pessoa
                        WHERE
                            c_pessoa_id = ?";
                
                $parametros = array($pessoa->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "success");
                }else{
                    $json = array("codigo" => 1, "message" => "error");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}
        
	public function buscaPorEmail(PessoaModel $pessoa){
            $json = Array();
            try{
                $sql = "SELECT 
                           *
                        FROM 
                            c_pessoa as p
                        WHERE
                            p.c_pessoa_email = ?";
                
                $parametros = array($pessoa->getLogin());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "indisponivel");
                }else{
                    $json = array("codigo" => 0, "message" => "disponivel");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);
	}

	public function buscaInstPessoa($busca, TipoUsuarioModel $tipoUsuario){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_pessoa_id as id, 
                            p.c_pessoa_nome as nome,
                            p.c_pessoa_email as email,
                            p.c_tipousuario_id as tipo_usuario
                        FROM 
                            c_pessoa as p
                        WHERE
                            c_tipousuario_id = ? AND
                            (c_pessoa_nome LIKE '%$busca%' OR
                            c_pessoa_email LIKE '%$busca%')";
                
                $parametros = array($tipoUsuario->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while ($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($json, $dados);
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);            
	}

	public function listarPorTipo(TipoUsuarioModel $tipo){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_pessoa_id as id, 
                            p.c_pessoa_nome as nome,
                            p.c_pessoa_email as email,
                            p.c_tipousuario_id as tipo_usuario
                        FROM 
                            c_pessoa as p
                        WHERE
                            p.c_tipousuario_id = ?";
                
                $parametros = array($tipo->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while ($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($json, $dados);
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);            
	}

	public function pessoaUltimoResgistro(){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_pessoa_id as id, 
                            p.c_pessoa_nome as nome,
                            p.c_pessoa_email as email,
                            p.c_tipousuario_id as tipo_usuario
                        FROM 
                            c_pessoa as p
                        ORDER BY
                            p.c_pessoa_id DESC";
                
                $parametros = array();
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = $rs->fetch(PDO::FETCH_OBJ);
                    
                    $pessoa = new PessoaModel();
                    $pessoa->setId($json->id);
                    return $pessoa;
                    
                }else{
                    $json = null;
                    return $json;
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
                return $json;
            }
            
	}


	public function alteraSenha(PessoaModel $pessoa, $novaSenha){
            
            $json = Array();
            if($this->verificaSenhaAntiga($pessoa) == "true"){
                try{
                
                    $sql = "UPDATE c_pessoa
                            SET
                                c_pessoa_senha = ?
                            WHERE 
                                c_pessoa_id = ?";

                    $parametros = array(md5($novaSenha),
                                        $pessoa->getId());

                    $rs = ConnectionFactory::getConection()->prepare($sql);
                    $rs->execute($parametros);

                    if($rs->rowCount() > 0){
                        $json = array("codigo" => 0, "message" => "success");
                    }else{
                        $json = array("codigo" => 1, "message" => "error");
                    }
                
                } catch (Exception $e){
                    $json = array("codigo"=> 1, "message" => $e->getMessage());
                }
            
            }else{
                $json = array("codigo" => 1, "message" => "Senha atual incorreta");
            }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}
        
	public function bloquear(PessoaModel $pessoa){
            $json = Array();
                try{
                
                    $sql = "UPDATE c_pessoa
                            SET
                                c_pessoa_bloq = 's'
                            WHERE 
                                c_pessoa_id = ?";

                    $parametros = array($pessoa->getId());

                    $rs = ConnectionFactory::getConection()->prepare($sql);
                    $rs->execute($parametros);

                    if($rs->rowCount() > 0){
                        $json = array("codigo" => 0, "message" => "success");
                    }else{
                        $json = array("codigo" => 1, "message" => "error");
                    }
                
                } catch (Exception $e){
                    $json = array("codigo"=> 1, "message" => $e->getMessage());
                }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}

	public function desbloquear(PessoaModel $pessoa){
            $json = Array();
                try{
                
                    $sql = "UPDATE c_pessoa
                            SET
                                c_pessoa_bloq = 'n'
                            WHERE 
                                c_pessoa_id = ?";

                    $parametros = array($pessoa->getId());

                    $rs = ConnectionFactory::getConection()->prepare($sql);
                    $rs->execute($parametros);

                    if($rs->rowCount() > 0){
                        $json = array("codigo" => 0, "message" => "success");
                    }else{
                        $json = array("codigo" => 1, "message" => "error");
                    }
                
                } catch (Exception $e){
                    $json = array("codigo"=> 1, "message" => $e->getMessage());
                }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}        
        
	public function resetar(PessoaModel $pessoa){
            $json = Array();
                try{
                    $senha = "mappinghsd";
                    $sql = "UPDATE c_pessoa
                            SET
                                c_pessoa_senha = ?
                            WHERE 
                                c_pessoa_id = ?";

                    $parametros = array(md5($senha), $pessoa->getId());

                    $rs = ConnectionFactory::getConection()->prepare($sql);
                    $rs->execute($parametros);

                    if($rs->rowCount() > 0){
                        $json = array("codigo" => 0, "message" => "success");
                    }else{
                        $json = array("codigo" => 1, "message" => "error");
                    }
                
                } catch (Exception $e){
                    $json = array("codigo"=> 1, "message" => $e->getMessage());
                }
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}        
        
        public function verificaSenhaAntiga(PessoaModel $pessoa){
            
            try{
                
                $sql = "SELECT * FROM 
                            c_pessoa
                        WHERE c_pessoa_senha = ? AND 
                              c_pessoa_id = ?";
                
                $parametros = array(md5($pessoa->getSenha()), 
                                    $pessoa->getId());
                
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
}