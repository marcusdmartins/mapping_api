<?php

include_once ('./dao/iRotinaDAO.php');

class RotinaDAO implements iRotinaDAO {

	public function save(RotinaModel $rotina){
            $json = Array();
            try{
                $sql = "INSERT INTO c_rotina
                                (c_rotina_nome, c_rotina_status, c_rotina_icon)
                            VALUES
                                (?,?,?)";
                $parametros = array($rotina->getNome(), $rotina->getStatus(), $rotina->getIcon());
                
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
        
	public function update(RotinaModel $rotina){
            
            $json = Array();
            try{
                $sql = "UPDATE c_rotina
                        SET
                            c_rotina_nome = ?,
                            c_rotina_status = ?,
                            c_rotina_icon = ?
                        WHERE 
                            c_rotina_id = ?";
                
                $parametros = array($rotina->getNome(),
                                    $rotina->getStatus(),
                                    $rotina->getIcon(),
                                    $rotina->getId());
                
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

	public function view(RotinaModel $rotina){
            $json = Array();
            try{
                $sql = "SELECT 
                            r.c_rotina_id as id, 
                            r.c_rotina_nome as nome,
                            r.c_rotina_status as status,
                            r.c_rotina_icon as icon
                        FROM 
                            c_rotina as r
                        WHERE
                            r.c_rotina_id = ?";
                
                $parametros = array($rotina->getId());
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
                            r.c_rotina_id as id, 
                            r.c_rotina_nome as nome,
                            r.c_rotina_status as status,
                            r.c_rotina_icon as icon
                        FROM 
                            c_rotina as r";
                
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

	public function delete(RotinaModel $rotina){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_rotina
                        WHERE
                            c_rotina_id = ?";
                
                $parametros = array($rotina->getId());
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