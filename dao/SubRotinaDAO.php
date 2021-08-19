<?php

include_once ('./dao/iSubRotinaDAO.php');

class SubRotinaDAO implements iSubRotinaDAO {

	public function save(SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "INSERT INTO c_subrotina
                                (c_rotina_id, 
                                 c_subrotina_nome, 
                                 c_subrotina_path, 
                                 c_subrotina_icon, 
                                 c_subrotina_menu)
                            VALUES
                                (?,?,?,?,?)";
                $parametros = array($subRotina->getRotina()->getId(), 
                                    $subRotina->getNome(), 
                                    $subRotina->getPath(), 
                                    $subRotina->getIcon(), 
                                    $subRotina->getMenu());
                
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
        
	public function update(SubRotinaModel $subRotina){
            
            $json = Array();
            try{
                $sql = "UPDATE c_subRotina
                        SET
                            c_rotina_id = ?, 
                            c_subrotina_nome = ?, 
                            c_subrotina_path = ?, 
                            c_subrotina_icon = ?, 
                            c_subrotina_menu = ?
                        WHERE 
                            c_subrotina_id = ?";
                
                $parametros = array($subRotina->getRotina()->getId(), 
                                    $subRotina->getNome(), 
                                    $subRotina->getPath(), 
                                    $subRotina->getIcon(), 
                                    $subRotina->getMenu(),
                                    $subRotina->getId());
                
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

	public function view(SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "SELECT 
                            sr.c_subrotina_id as id,
                            sr.c_rotina_id as rotina_id, 
                            sr.c_subrotina_nome as nome, 
                            sr.c_subrotina_path as path, 
                            sr.c_subrotina_icon as icon, 
                            sr.c_subrotina_menu as menu
                        FROM 
                            c_subrotina as sr
                        WHERE
                           sr.c_subrotina_id = ?";
                
                $parametros = array($subRotina->getId());
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
                            sr.c_subrotina_id as id,
                            sr.c_rotina_id as rotina_id, 
                            sr.c_subrotina_nome as nome, 
                            sr.c_subrotina_path as path, 
                            sr.c_subrotina_icon as icon, 
                            sr.c_subrotina_menu as menu
                        FROM 
                            c_subrotina as sr";
                
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

	public function delete(SubRotinaModel $subRotina){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_subrotina
                        WHERE
                            c_subrotina_id = ?";
                
                $parametros = array($subRotina->getId());
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