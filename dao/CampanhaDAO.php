<?php

include_once ('./dao/iCampanhaDAO.php');

class CampanhaDAO implements iCampanhaDAO {

	public function save(CampanhaModel $campanha){
            $json = Array();
            try{
                $sql = "INSERT INTO c_campanha
                                (c_campanha_nome, 
                                 c_campanha_descricao,
                                 c_campanha_ambiente,
                                 c_campanha_layout, 
                                 c_campanha_inicio, 
                                 c_campanha_fim, 
                                 c_campanha_status, 
                                 c_pessoa_id)
                            VALUES
                                (?,?,?,?,?,?,?,?)";
                $parametros = array($campanha->getNome(),
                                    $campanha->getDescricao(),
                                    $campanha->getAmbiente(),
                                    $campanha->getLayout(),
                                    $campanha->getInicio(),
                                    $campanha->getFim(),
                                    $campanha->getStatus(),
                                    $campanha->getPessoa()->getId());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
//                    $json = array("codigo" => 0, "message" => "success");
                    $id = $this->buscaUltimaCampanha();
                    return $id;
                }else{
//                    $json = array("codigo" => 1, "message" => "error");
                    return "error";
                }
                
            } catch (Exception $e){
//                $json = array("codigo" => 1, "message" => $e->getMessage());
                return $e->getMessage();
            }
            
//            header("Content-Type: application/json");
//            echo json_encode($json);
	}
        
	public function update(CampanhaModel $campanha){
            
            $json = Array();
            try{
                $sql = "UPDATE c_campanha
                        SET
                            c_campanha_nome = ?, 
                            c_campanha_descricao = ?, 
                            c_campanha_ambiente = ?,
                            c_campanha_inicio = ?, 
                            c_campanha_fim = ?, 
                            c_campanha_status = ?
                        WHERE 
                            c_campanha_id = ?";
                
                $parametros = array($campanha->getNome(),
                                    $campanha->getDescricao(),
                                    $campanha->getAmbiente(),
                                    $campanha->getInicio(),
                                    $campanha->getFim(),
                                    $campanha->getStatus(),
                                    $campanha->getId());
                
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
        
	public function updateLayout(CampanhaModel $campanha){
            
            $json = Array();
            try{
                $sql = "UPDATE c_campanha
                        SET 
                            c_campanha_layout = ?
                        WHERE 
                            c_campanha_id = ?";
                
                $parametros = array($campanha->getLayout(),
                                    $campanha->getId());
                
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

	public function view(CampanhaModel $campanha){
            $json = Array();
            try{
                $sql = "SELECT 
                            c_campanha_id as id, 
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao,
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM 
                            c_campanha as c
                        WHERE
                            c.c_campanha_id = ?";
                
                $parametros = array($campanha->getId());
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
                            c_campanha_id as id,
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao, 
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM 
                            c_campanha as c
                        ORDER BY
                            c_campanha_inicio ASC";
                
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
        
	public function buscaCampanhaInst($busca, $ambiente){
            $json = Array();
            
            if($ambiente != "TODOS"){
                $clause_ambiente = "AND c.c_campanha_ambiente = ?";
            }else{
                $clause_ambiente = "";
            }
            
            try{
                $sql = "SELECT 
                            c_campanha_id as id,
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao, 
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM 
                            c_campanha as c
                        WHERE
                            (c_campanha_nome LIKE '%$busca%' OR
                            c_campanha_descricao LIKE '%$busca%')"
                            .$clause_ambiente."
                        ORDER BY
                            c_campanha_nome ASC";
                
                $parametros = array($ambiente);
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

	public function delete(CampanhaModel $campanha){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_campanha
                        WHERE
                            c_campanha_id = ?";
                
                $parametros = array($campanha->getId());
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
            
            header("Content-Type: application/ json");
            echo json_encode ($json);             
	}
        
        public function inserePublico(CampanhaModel $campanha, PublicoModel $publico){
            try{
                $sql = "INSERT INTO m_campanhapublico
                        (c_campanha_id, c_publico_id)
                        VALUES
                        (?,?)";
                $parametros = array($campanha->getId(), $publico->getId());
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
        
	public function buscaUltimaCampanha(){
            $json = Array();
            try{
                $sql = "SELECT 
                            c_campanha_id as id
                        FROM 
                            c_campanha as c
                        ORDER BY
                            c.c_campanha_id DESC";
                
                $parametros = array();
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $dados = $rs->fetch(PDO::FETCH_OBJ);
                    return $dados->id;
                }else{
                    return "nenhum";
                }
            } catch (Exception $e){
                return $e->getMessage();
            }
	}

        public function deletarPublicos(CampanhaModel $campanha){
            try{
                $sql = "DELETE FROM m_campanhapublico
                        WHERE c_campanha_id = ?";
                $parametros = array($campanha->getId());
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
        
        public function validaPublicoCampanha(PublicoModel $publico, CampanhaModel $campanha){
            $json = array();
            try{
                $sql = "SELECT * FROM m_campanhapublico
                        WHERE
                        c_publico_id = ? AND
                        c_campanha_id = ?";
                $parametros = array($publico->getId(), $campanha->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $json = array("codigo" => 0, "message" => "true");
                }else{
                    $json = array("codigo" => 1, "message" => "false");
                }
            }catch(Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            header("Content-Type: application/json");
            echo json_encode ($json);             
        }
        
        public function buscaPublicosPorCampanha(CampanhaModel $campanha){
            $json = array();
            try{
                $sql = "SELECT 
                            cp.m_campanhapublico_id as id,
                            cp.c_campanha_id as id_campanha,
                            c_campanha_nome as nome_campanha,
                            cp.c_publico_id as id_publico,
                            p.c_publico_nome as nome_publico
                        FROM
                            m_campanhapublico as cp,
                            c_campanha as c,
                            c_publico as p
                        WHERE
                            cp.c_campanha_id = c.c_campanha_id AND
                            cp.c_publico_id = p.c_publico_id AND
                            cp.c_campanha_id = ?";
                $parametros = array($campanha->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($json, $dados);
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            }catch(Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function buscaProximasCampanhas(){
            $data = date("Y-m-d");
            $json = array();
            try{
                $sql = "SELECT
                            c_campanha_id as id,
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao, 
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM
                            c_campanha as c
                        WHERE
                            c.c_campanha_inicio > ?
                        ORDER BY
                            c.c_campanha_inicio ASC
                        LIMIT 5";
                $parametros = array($data);
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
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function buscaCampanhasEmAndamento(){
            $data = date("Y-m-d");
            $json = array();
            try{
                $sql = "SELECT
                            c_campanha_id as id,
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao, 
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM
                            c_campanha as c
                        WHERE
                            ? between c.c_campanha_inicio and c.c_campanha_fim
                        ORDER BY
                            c.c_campanha_inicio ASC
                        LIMIT 5";
                $parametros = array($data);
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
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }

        public function custoPorCampanha(CampanhaModel $campanha){
            $json = array();
            try{
                $sql = "SELECT 
                            sum(cl.c_ciclo_custo) as soma
                        FROM
                            c_publicidade as p,
                            c_ciclo as cl
                        WHERE
                            p.c_publicidade_id = cl.c_publicidade_id AND
                            p.c_campanha_id = ?";
                $parametros = array($campanha->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                $result = $rs->fetch(PDO::FETCH_OBJ);
                $json = array("custo" => $result->soma);
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
	public function buscaCampanhaPorAmbiente($ambiente){
            $json = Array();
            try{
                $sql = "SELECT 
                            c_campanha_id as id,
                            c_campanha_nome as nome, 
                            c_campanha_descricao as descricao, 
                            c_campanha_ambiente as ambiente,
                            c_campanha_layout as layout, 
                            c_campanha_inicio as inicio, 
                            c_campanha_fim fim, 
                            c_campanha_status status, 
                            c_pessoa_id as pessoa_id
                        FROM 
                            c_campanha as c
                        WHERE
                            c_campanha_ambiente = ?
                        ORDER BY
                            c_campanha_inicio ASC";
                
                $parametros = array($ambiente);
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
}