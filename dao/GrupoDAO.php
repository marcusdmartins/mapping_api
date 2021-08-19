<?php

include_once ('./dao/iGrupoDAO.php');

class GrupoDAO implements iGrupoDAO {

	public function save(GrupoModel $grupo){
            $json = Array();
            try{
                $sql = "INSERT INTO c_grupo
                                (c_grupo_nome)
                            VALUES
                                (?)";
                $parametros = array($grupo->getNome());
                
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
        
	public function update(GrupoModel $grupo){
            
            $json = Array();
            try{
                $sql = "UPDATE c_grupo
                        SET
                            c_grupo_nome = ?
                        WHERE 
                            c_grupo_id = ?";
                
                $parametros = array($grupo->getNome(), $grupo->getId());
                
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

	public function view(GrupoModel $grupo){
            $json = Array();
            try{
                $sql = "SELECT 
                            g.c_grupo_id as id, 
                            g.c_grupo_nome as nome
                        FROM 
                            c_grupo as g
                        WHERE
                            g.c_grupo_id = ?";
                
                $parametros = array($grupo->getId());
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
                            g.c_grupo_id as id, 
                            g.c_grupo_nome as nome
                        FROM 
                            c_grupo as g
                        WHERE
                            c_grupo_id != 1
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

	public function delete(GrupoModel $grupo){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_grupo
                        WHERE
                            c_grupo_id = ?";
                
                $parametros = array($grupo->getId());
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