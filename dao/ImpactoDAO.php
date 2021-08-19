<?php

include_once ('iImpactoDAO.php');

class ImpactoDAO implements iImpactoDAO {

	public function save(ImpactoModel $impacto){
            try{
                $sql = "INSERT INTO m_localpublico
                                (c_local_id,
                                c_publico_id,
                                m_localpublico_impacto)
                            VALUES
                                (?,?,?)";
                $parametros = array($impacto->getLocal()->getId(), $impacto->getPublico()->getId(), $impacto->getImpacto());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
//                    $json = array("codigo" => 0, "message" => "success");
                    return "success";
                }else{
//                    $json = array("codigo" => 1, "message" => "error");
                    return "error";
                }
                
            } catch (Exception $e){
//                $json = array("codigo" => 1, "message" => $e->getMessage());
                return $e->getMessage();
            }

	}
        
	public function update(ImpactoModel $impacto){
            
            $json = Array();
            try{
                $sql = "UPDATE m_localpublico
                        SET
                            c_local_id = ?,
                            c_publico_id = ?,
                            m_localpublico_impacto = ?
                        WHERE 
                            m_localpublico_id = ?";
                
                $parametros = array($impacto->getLocal()->getId(), $impacto->getPublico()->getId(), $impacto->getImpacto(), $impacto->getId());
                
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

	public function view(ImpactoModel $impacto){
            $json = Array();
            try{
                $sql = "SELECT 
                            i.m_localpublico_id as id,
                            i.c_local_id as id_local,
                            i.c_publico_id as id_publico,
                            i.m_localpublico_impacto as impacto
                        FROM 
                            m_localpublico as i
                        WHERE
                            i.m_localpublico_id = ?";
                
                $parametros = array($impacto->getId());
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
                            i.m_localpublico_id as id,
                            i.c_local_id as id_local,
                            i.c_publico_id as id_publico,
                            i.m_localpublico_impacto as impacto
                        FROM 
                            m_localpublico as i";
                
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
        
	public function impactoPorPublicoLocal(PublicoModel $publico, LocalModel $local){
            $json = Array();
            try{
                $sql = "SELECT 
                            i.m_localpublico_id as id,
                            i.c_local_id as id_local,
                            i.c_publico_id as id_publico,
                            i.m_localpublico_impacto as impacto
                        FROM 
                            m_localpublico as i
                        WHERE
                            i.c_local_id = ? AND
                            i.c_publico_id = ?";
                
                $parametros = array($local->getId(), $publico->getId());
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
        
        public function impactosPorLocal(LocalModel $local){
            $json = array();
            try{
                $sql = "SELECT 
                            lp.c_local_id as id_local,
                            lp.c_publico_id as id_publico,
                            p.c_publico_nome as nome_publico,
                            lp.m_localpublico_impacto as impacto
                        FROM 
                            m_localpublico as lp, 
                            c_publico as p
                        WHERE
                            lp.c_publico_id = p.c_publico_id AND
                            lp.c_local_id = ?";
                
                $parametros = array($local->getId());
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
            
            header('Content-Type: application/json');
            echo json_encode($json);
        }

	public function delete(LocalModel $local){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            m_localpublico
                        WHERE
                            c_local_id = ?";
                
                $parametros = array($local->getId());
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