<?php

include_once ('./dao/iPublicoDAO.php');

class PublicoDAO implements iPublicoDAO {

	public function save(PublicoModel $publico){
            $json = Array();
            try{
                $sql = "INSERT INTO c_publico
                                (c_publico_nome)
                            VALUES
                                (?)";
                $parametros = array($publico->getNome());
                
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
            
            header("Content-Type: application/json");
            echo json_encode($json);
	}
        
	public function update(PublicoModel $publico){
            
            $json = Array();
            try{
                $sql = "UPDATE c_publico
                        SET
                            c_publico_nome = ?
                        WHERE 
                            c_publico_id = ?";
                
                $parametros = array($publico->getNome(), $publico->getId());
                
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

	public function view(PublicoModel $publico){
            $json = Array();
            try{
                $sql = "SELECT 
                            g.c_publico_id as id, 
                            g.c_publico_nome as nome
                        FROM 
                            c_publico as g
                        WHERE
                            g.c_publico_id = ?";
                
                $parametros = array($publico->getId());
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
                            g.c_publico_id as id, 
                            g.c_publico_nome as nome
                        FROM 
                            c_publico as g
                        ORDER BY nome ASC";
                
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

	public function delete(PublicoModel $publico){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_publico
                        WHERE
                            c_publico_id = ?";
                
                $parametros = array($publico->getId());
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
        
        public function publicoPorCampanha(CampanhaModel $campanha){
            $json = array();
            try{
                $sql = "SELECT
                            cp.c_campanha_id as id_campanha,
                            cp.c_publico_id as id_publico,
                            p.c_publico_nome as nome_publico
                        FROM
                            m_campanhapublico as cp,
                            c_publico as p
                        WHERE
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
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function mediaImpactoCampanha(CampanhaModel $campanha, PublicoModel $publico){
            $json = array();
            try{
                $sql = "SELECT 
                            p.c_publicidade_id as id_publicidade,
                            p.c_publicidade_descricao as descricao,
                            l.c_local_nome as nome_local,
                            pub.c_publico_nome as nome_publico,
                            lp.m_localpublico_impacto as impacto                     
                        FROM
                            c_publicidade as p,
                            c_local as l,
                            c_publico as pub,
                            m_localpublico as lp
                        WHERE
                            p.c_local_id = l.c_local_id AND
                            l.c_local_id = lp.c_local_id AND
                            pub.c_publico_id = lp.c_publico_id AND
                            p.c_campanha_id = ? AND
                            pub.c_publico_id = ?";
                $parametros = array($campanha->getId(), $publico->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                $soma = $this->somaImpactoCampanha($campanha, $publico);
                $media = $soma/$rs->rowCount();
                $json = array("media" => (int)$media);
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function somaImpactoCampanha(CampanhaModel $campanha, PublicoModel $publico){
            try{
                $sql = "SELECT 
                            sum(lp.m_localpublico_impacto) as soma                    
                        FROM
                            c_publicidade as p,
                            c_local as l,
                            c_publico as pub,
                            m_localpublico as lp
                        WHERE
                            p.c_local_id = l.c_local_id AND
                            l.c_local_id = lp.c_local_id AND
                            pub.c_publico_id = lp.c_publico_id AND
                            p.c_campanha_id = ? AND
                            pub.c_publico_id = ?";
                $parametros = array($campanha->getId(), $publico->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                                
                $dados = $rs->fetch(PDO::FETCH_OBJ);
                return $dados->soma;
                
            } catch (Exception $e){
                return $e->getMessage();
            }
        }        
}