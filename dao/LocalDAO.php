<?php

include_once ('./dao/iLocalDAO.php');

class LocalDAO implements iLocalDAO {

	public function save(LocalModel $local){
            try{
                $sql = "INSERT INTO c_local
                                (c_subgrupo_id,
                                c_local_nome)
                            VALUES
                                (?,?)";
                $parametros = array($local->getSubgrupo()->getId(), $local->getNome());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                        $ultimo = $this->buscaUltimoLocal();
                        return $ultimo->id;
                }else{
                    return "error";
                }
                
            } catch (Exception $e){
                return $e->getMessage();
            }

	}
        
	public function update(LocalModel $local){
            try{
                $sql = "UPDATE c_local
                        SET
                            c_local_nome = ?,
                            c_subgrupo_id = ?
                        WHERE 
                            c_local_id = ?";
                
                $parametros = array($local->getNome(), $local->getSubgrupo()->getId(), $local->getId());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    return "error";
                }else{
                    return "error";
                }
            } catch (Exception $e){
                return $e->getMessage();
            }        
	}        

	public function view(LocalModel $local){
            $json = Array();
            try{
                $sql = "SELECT 
                            l.c_local_id as id, 
                            sg.c_subgrupo_id as id_subgrupo,
                            sg.c_subgrupo_nome as nome_subgrupo,                            
                            l.c_local_nome as nome
                        FROM 
                            c_local as l,
                            c_subgrupo as sg
                        WHERE
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            l.c_local_id = ?";
                
                $parametros = array($local->getId());
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
                            l.c_local_id as id, 
                            sg.c_subgrupo_id as id_subgrupo,
                            sg.c_subgrupo_nome as nome_subgrupo,                            
                            l.c_local_nome as nome,
                            sg.c_grupo_id as id_grupo,
                            g.c_grupo_nome as nome_grupo
                        FROM 
                            c_local as l,
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            sg.c_grupo_id = g.c_grupo_id
                        ORDER BY
                            l.c_subgrupo_id ASC";
                
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
        
	public function localPorSubgrupo(SubGrupoModel $subgrupo){
            $json = Array();
            try{
                $sql = "SELECT 
                            l.c_local_id as id, 
                            sg.c_subgrupo_id as id_subgrupo,
                            sg.c_subgrupo_nome as nome_subgrupo,                            
                            l.c_local_nome as nome
                        FROM 
                            c_local as l,
                            c_subgrupo as sg
                        WHERE
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            l.c_subgrupo_id = ?
                        ORDER BY
                            l.c_subgrupo_id ASC";
                
                $parametros = array($subgrupo->getId());
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

	public function delete(LocalModel $local){
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_local
                        WHERE
                            c_local_id = ?";
                
                $parametros = array($local->getId());
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
        
	public function buscaUltimoLocal(){
            try{
                $sql = "SELECT 
                            l.c_local_id as id
                        FROM 
                            c_local as l
                        ORDER BY
                            l.c_local_id DESC";
                
                $parametros = array();
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $dados = $rs->fetch(PDO::FETCH_OBJ);
                    return $dados;
                }else{
                    return "nenhum";
                }
                
            } catch (Exception $e){
                $json = array("codigo"=> 1, "message" => $e->getMessage());
            }
	}        
}