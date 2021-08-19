<?php

include_once ('./dao/iCicloDAO.php');

class CicloDAO implements iCicloDAO {

	public function save(CicloModel $ciclo){
            $json = Array();
            try{
                $sql = "INSERT INTO c_ciclo
                                (c_publicidade_id,
                                 c_ciclo_inicio,
                                 c_ciclo_fim,
                                 c_ciclo_custo,
                                 c_ciclo_status)
                            VALUES
                                (?,?,?,?,?)";
                
                $parametros = array($ciclo->getPublicidade()->getId(),
                                    $ciclo->getInicio(),
                                    $ciclo->getFim(),
                                    $ciclo->getCusto(),
                                    $ciclo->getStatus());
                
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
        
	public function update(CicloModel $ciclo){
            
            $json = Array();
            try{
                $sql = "UPDATE c_ciclo
                        SET
                            c_ciclo_inicio = ?,
                            c_ciclo_fim = ?,
                            c_ciclo_custo = ?,
                            c_ciclo_status = ?
                        WHERE 
                            c_ciclo_id = ?";
                
                $parametros = array($ciclo->getInicio(),
                                    $ciclo->getFim(),
                                    $ciclo->getCusto(),
                                    $ciclo->getStatus(),
                                    $ciclo->getId());
                
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

	public function view(CicloModel $ciclo){
            $json = Array();
            try{
                $sql = "SELECT 
                            c.c_publicidade_id as id_publicidade,
                            c.c_ciclo_inicio as inicio,
                            c.c_ciclo_fim as fim,
                            c.c_ciclo_custo as custo,
                            c.c_ciclo_status as status
                        FROM 
                            c_ciclo as c
                        WHERE
                            c.c_ciclo_id = ?";
                
                $parametros = array($ciclo->getId());
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
                            c.c_publicidade_id as id_publicidade,
                            c.c_ciclo_inicio as inicio,
                            c.c_ciclo_fim as fim,
                            c.c_ciclo_custo as custo,
                            c.c_ciclo_status as status
                        FROM 
                            c_ciclo as c";
                
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

	public function delete(CicloModel $ciclo){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_ciclo
                        WHERE
                            c_ciclo_id = ?";
                
                $parametros = array($ciclo->getId());
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
}