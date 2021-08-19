<?php

include_once ('./dao/iSubGrupoDAO.php');

class SubGrupoDAO implements iSubGrupoDAO {

	public function save(SubGrupoModel $subgrupo){
            $json = Array();
            try{
                $sql = "INSERT INTO c_subgrupo
                                (c_grupo_id, c_subgrupo_nome)
                            VALUES
                                (?,?)";
                $parametros = array($subgrupo->getGrupo()->getId(), $subgrupo->getNome());
                
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
        
	public function update(SubGrupoModel $subgrupo){
            
            $json = Array();
            try{
                $sql = "UPDATE c_subgrupo
                        SET
                            c_subgrupo_nome = ?,
                            c_grupo_id = ?
                        WHERE 
                            c_subgrupo_id = ?";
                
                $parametros = array($subgrupo->getNome(), $subgrupo->getGrupo()->getId(), $subgrupo->getId());
                
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

	public function view(SubGrupoModel $subgrupo){
            $json = Array();
            try{
                $sql = "SELECT 
                            sg.c_subgrupo_id as id, 
                            g.c_grupo_id as id_grupo,
                            g.c_grupo_nome as nome_grupo,                           
                            sg.c_subgrupo_nome as nome
                        FROM 
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            sg.c_grupo_id = g.c_grupo_id AND
                            sg.c_subgrupo_id = ?";
                
                $parametros = array($subgrupo->getId());
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
                            sg.c_subgrupo_id as id, 
                            g.c_grupo_id as id_grupo,
                            g.c_grupo_nome as nome_grupo,                            
                            sg.c_subgrupo_nome as nome
                        FROM 
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            sg.c_grupo_id = g.c_grupo_id
                        ORDER BY
                            nome ASC";
                
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
        
	public function subgrupoPorGrupo(GrupoModel $grupo){
            $json = Array();
            try{
                $sql = "SELECT 
                            sg.c_subgrupo_id as id, 
                            g.c_grupo_id as id_grupo,
                            g.c_grupo_nome as nome_grupo,                            
                            sg.c_subgrupo_nome as nome
                        FROM 
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            sg.c_grupo_id = g.c_grupo_id AND
                            g.c_grupo_id = ?
                        ORDER BY
                            nome ASC";
                
                $parametros = array($grupo->getId());
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

	public function delete(SubGrupoModel $subgrupo){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_subgrupo
                        WHERE
                            c_subgrupo_id = ?";
                
                $parametros = array($subgrupo->getId());
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