<?php

include_once ('./dao/iTipoMidiaDAO.php');

class TipoMidiaDAO implements iTipoMidiaDAO {

	public function save(TipoMidiaModel $tipomidia){
            $json = Array();
            try{
                $sql = "INSERT INTO c_tipomidia
                                (c_tipomidia_nome)
                            VALUES
                                (?)";
                $parametros = array($tipomidia->getNome());
                
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
        
	public function update(TipoMidiaModel $tipomidia){
            
            $json = Array();
            try{
                $sql = "UPDATE c_tipomidia
                        SET
                            c_tipomidia_nome = ?
                        WHERE 
                            c_tipomidia_id = ?";
                
                $parametros = array($tipomidia->getNome(), $tipomidia->getId());
                
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

	public function view(TipoMidiaModel $tipomidia){
            $json = Array();
            try{
                $sql = "SELECT 
                            g.c_tipomidia_id as id, 
                            g.c_tipomidia_nome as nome
                        FROM 
                            c_tipomidia as g
                        WHERE
                            g.c_tipomidia_id = ?";
                
                $parametros = array($tipomidia->getId());
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
                            g.c_tipomidia_id as id, 
                            g.c_tipomidia_nome as nome
                        FROM 
                            c_tipomidia as g
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

	public function delete(TipoMidiaModel $tipomidia){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_tipomidia
                        WHERE
                            c_tipomidia_id = ?";
                
                $parametros = array($tipomidia->getId());
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