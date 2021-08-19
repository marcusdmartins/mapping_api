<?php

include_once ('./dao/iMidiaDAO.php');

class MidiaDAO implements iMidiaDAO {

	public function save(MidiaModel $midia){
            $json = Array();
            try{
                $sql = "INSERT INTO c_midia
                                (c_midia_nome, c_midia_icon, c_tipomidia_id)
                            VALUES
                                (?,?,?)";
                $parametros = array($midia->getNome(), $midia->getIcon(), $midia->getTipomidia()->getId());
                
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
        
	public function update(MidiaModel $midia){
            
            $json = Array();
            try{
                $sql = "UPDATE c_midia
                        SET
                            c_midia_nome = ?,
                            c_midia_icon = ?,
                            c_tipomidia_id = ?
                        WHERE 
                            c_midia_id = ?";
                
                $parametros = array($midia->getNome(), $midia->getIcon(), $midia->getTipomidia()->getId(), $midia->getId());
                
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

	public function view(MidiaModel $midia){
            $json = Array();
            try{
                $sql = "SELECT 
                            m.c_midia_id as id, 
                            m.c_midia_nome as nome,
                            m.c_midia_icon as icon,
                            m.c_tipomidia_id as id_tipomidia,
                            tm.c_tipomidia_nome as nome_tipomidia
                        FROM 
                            c_midia as m,
                            c_tipomidia as tm
                        WHERE
                            m.c_tipomidia_id = tm.c_tipomidia_id AND
                            m.c_midia_id = ?";
                
                $parametros = array($midia->getId());
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
                            m.c_midia_id as id, 
                            m.c_midia_nome as nome,
                            m.c_midia_icon as icon,
                            m.c_tipomidia_id as id_tipomidia,
                            tm.c_tipomidia_nome as nome_tipomidia
                        FROM 
                            c_midia as m,
                            c_tipomidia as tm
                        WHERE
                            m.c_tipomidia_id = tm.c_tipomidia_id";
                
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

	public function delete(MidiaModel $midia){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_midia
                        WHERE
                            c_midia_id = ?";
                
                $parametros = array($midia->getId());
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
        
	public function buscaMidiaPorTipo(TipoMidiaModel $tipomidia){
            $json = Array();
            try{
                $sql = "SELECT 
                            m.c_midia_id as id, 
                            m.c_midia_nome as nome,
                            m.c_midia_icon as icon,
                            m.c_tipomidia_id as id_tipomidia,
                            tm.c_tipomidia_nome as nome_tipomidia
                        FROM 
                            c_midia as m,
                            c_tipomidia as tm
                        WHERE
                            m.c_tipomidia_id = tm.c_tipomidia_id AND
                            m.c_tipomidia_id = ?";
                
                $parametros = array($tipomidia->getId());
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