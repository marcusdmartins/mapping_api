<?php

include_once ('./dao/iTipoUsuarioDAO.php');

class TipoUsuarioDAO implements iTipoUsuarioDAO {

	public function save(TipoUsuarioModel $tipoUsuario){
            $json = Array();
            try{
                $sql = "INSERT INTO `c_tipousuario`
                                (c_tipousuario_nome)
                            VALUES
                                (?)";
                $parametros = array($tipoUsuario->getNome());
                
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
        
	public function update(TipoUsuarioModel $tipoUsuario){
            
            $json = Array();
            try{
                $sql = "UPDATE c_tipousuario
                        SET
                            c_tipousuario_nome = ?
                        WHERE 
                            c_tipousuario_id = ?";
                
                $parametros = array($tipoUsuario->getNome(),
                                    $tipoUsuario->getId());
                
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

	public function view(TipoUsuarioModel $tipoUsuario){
            $json = Array();
            try{
                $sql = "SELECT 
                            t.c_tipousuario_id as id, 
                            t.c_tipousuario_nome as nome
                        FROM 
                            c_tipousuario as t
                        WHERE
                            t.c_tipousuario_id = ?";
                
                $parametros = array($tipoUsuario->getId());
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
                            t.c_tipousuario_id as id, 
                            t.c_tipousuario_nome as nome
                        FROM 
                            c_tipousuario as t";
                
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

	public function delete(TipoUsuarioModel $tipoUsuario){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_tipousuario
                        WHERE
                            c_tipousuario_id = ?";
                
                $parametros = array($tipoUsuario->getId());
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
}