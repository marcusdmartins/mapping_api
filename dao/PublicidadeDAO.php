<?php

include_once ('./dao/iPublicidadeDAO.php');

class PublicidadeDAO implements iPublicidadeDAO {

	public function save(PublicidadeModel $publicidade){
            $json = Array();
            try{
                $sql = "INSERT INTO c_publicidade
                                (c_publicidade_descricao,
                                 c_campanha_id,
                                 c_midia_id,
                                 c_publicidade_ambiente,
                                 c_local_id,
                                 c_publicidade_lat,
                                 c_publicidade_long,
                                 c_publicidade_status,
                                 c_pessoa_id)
                            VALUES
                                (?,?,?,?,?,?,?,?,?)";
                
                $parametros = array($publicidade->getDescricao(),
                                    $publicidade->getCampanha()->getId(),
                                    $publicidade->getMidia()->getId(),
                                    $publicidade->getAmbiente(),
                                    $publicidade->getLocal()->getId(),
                                    $publicidade->getLatitude(),
                                    $publicidade->getLongitude(),
                                    $publicidade->getStatus(),
                                    $publicidade->getPessoa()->getId());
                
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $novaPub = $this->buscaUltimaPublicidade();
                    return $novaPub->id;
                }else{
                    return "error";
                }
                
            } catch (Exception $e){
                return $e->getMessage();
            }
	}
        
	public function update(PublicidadeModel $publicidade){
            $json = Array();
            try{
                $sql = "UPDATE c_publicidade
                        SET
                            c_publicidade_descricao = ?,
                            c_campanha_id = ?,
                            c_midia_id = ?,
                            c_local_id = ?,
                            c_publicidade_lat = ?,
                            c_publicidade_long = ?,
                            c_publicidade_status = ?,
                            c_pessoa_id = ?
                        WHERE 
                            c_publicidade_id = ?";
                
                $parametros = array($publicidade->getDescricao(),
                                    $publicidade->getCampanha()->getId(),
                                    $publicidade->getMidia()->getId(),
                                    $publicidade->getLocal()->getId(),
                                    $publicidade->getLatitude(),
                                    $publicidade->getLongitude(),
                                    $publicidade->getStatus(),
                                    $publicidade->getPessoa()->getId(),
                                    $publicidade->getId());
                
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

	public function view(PublicidadeModel $publicidade){
            $json = Array();
            try{
                $sql = "SELECT 
                            p.c_publicidade_descricao as descricao,
                            p.c_publicidade_id as id,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            p.c_midia_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_local_id as id_local,
                            l.c_local_nome as nome_local,
                            p.c_publicidade_lat as latitude,
                            p.c_publicidade_long as longitude,
                            p.c_publicidade_status as status,
                            p.c_pessoa_id as id_pessoa,
                            ps.c_pessoa_nome as nome_pessoa
                        FROM 
                            c_publicidade as p,
                            c_campanha as c,
                            c_midia as m,
                            c_local as l,
                            c_pessoa as ps
                        WHERE
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_local_id = l.c_local_id AND
                            p.c_pessoa_id = ps.c_pessoa_id AND
                            p.c_publicidade_id = ?";
                
                $parametros = array($publicidade->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $dados = $rs->fetch(PDO::FETCH_OBJ);
                    
                    $json = array(
                        "id" => $dados->id,
                        "descricao" => $dados->descricao,
                        "id_campanha" => $dados->id_campanha,
                        "nome_campanha" => $dados->nome_campanha,
                        "id_midia" => $dados->id_midia,
                        "nome_midia" => $dados->nome_midia,
                        "ambiente" => $dados->ambiente,
                        "id_local" => $dados->id_local,
                        "nome_local" => $dados->nome_local,
                        "latitude" => $dados->latitude,
                        "longitude" => $dados->longitude,
                        "status" => $dados->status,
                        "id_pessoa" => $dados->id_pessoa,
                        "ciclo" => $this->buscaCiclosPublicidade($publicidade)
                    );
                    
                }else{
                    $json = array("codigo" => 0, "message" => "nenhum");
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
                            p.c_publicidade_descricao as descricao,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            p.c_midia_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_local_id as id_local,
                            l.c_local_nome as nome_local,
                            p.c_publicidade_lat as latitude,
                            p.c_publicidade_long as longitude,
                            p.c_publicidade_status as status,
                            p.c_pessoa_id as id_pessoa,
                            ps.c_pessoa_nome as nome_pessoa
                        FROM 
                            c_publicidade as p,
                            c_campanha as c,
                            c_midia as m,
                            c_local as l,
                            c_pessoa as ps
                        WHERE
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_local_id = l.c_local_id AND
                            p.c_pessoa_id = ps.c_pessoa_id";
                
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

	public function delete(PublicidadeModel $publicidade){
            $this->deletarCiclosPublicidade($publicidade);
            $json = Array();
            try{
                $sql = "DELETE FROM 
                            c_publicidade
                        WHERE
                            c_publicidade_id = ?";
                
                $parametros = array($publicidade->getId());
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
        
        public function buscaUltimaPublicidade(){
            $json = array();
            try{
                $sql = "SELECT
                            c_publicidade_id as id
                        FROM
                            c_publicidade
                        ORDER BY
                            c_publicidade_id DESC";
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute();
                
                if($rs->rowCount() > 0){
                    $dados = $rs->fetch(PDO::FETCH_OBJ);
                    return $dados;
                }else{
                    return "nenhum";
                }
                
            } catch (Exception $e){
                return $e->getMessage();
            }
        }
        
        public function buscaPublicidadePorLocal(LocalModel $local){
            $json = Array();
            try{
                $sql = "SELECT
                            p.c_publicidade_id as id_publicidade,
                            p.c_publicidade_descricao as descricao,
                            p.c_publicidade_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_publicidade_status as status_publicidade,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            c.c_campanha_layout as layout_campanha,
                            p.c_local_id as id_local,
                            l.c_local_nome as nome_local,
                            p.c_pessoa_id as id_pessoa
                        FROM 
                            c_publicidade as p,
                            c_midia as m,
                            c_campanha as c,
                            c_local as l
                        WHERE
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_local_id = l.c_local_id AND
                            p.c_publicidade_status = 'a' AND
                            p.c_local_id = ?
                        ORDER BY
                            nome_midia ASC";
                $parametros = array($local->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        $publicidade1 = new PublicidadeModel();
                        $publicidade1->setId($dados->id_publicidade);
                        array_push($json, array(
                                        "id" => $dados->id_publicidade,
                                        "descricao" => $dados->descricao,
                                        "id_campanha" => $dados->id_campanha,
                                        "nome_campanha" => $dados->nome_campanha,
                                        "id_midia" => $dados->id_midia,
                                        "nome_midia" => $dados->nome_midia,
                                        "ambiente" => $dados->ambiente,
                                        "id_local" => $dados->id_local,
                                        "nome_local" => $dados->nome_local,
                                        "status" => $dados->status_publicidade,
                                        "layout_campanha" => $dados->layout_campanha,
                                        "id_pessoa" => $dados->id_pessoa,
                                        "ciclo" => $this->buscaUltimoCicloPublicidade($publicidade1)));
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function buscaCiclosPublicidade(PublicidadeModel $publicidade){
            $dados = array();
            try{
                $sql = "SELECT 
                            cl.c_ciclo_id as id,
                            cl.c_ciclo_inicio as ciclo_inicio,
                            cl.c_ciclo_fim as ciclo_fim,
                            cl.c_ciclo_status as ciclo_status,
                            cl.c_ciclo_custo as ciclo_custo
                        FROM 
                            c_ciclo as cl
                        WHERE
                            cl.c_publicidade_id = ?
                        ORDER BY
                            cl.c_ciclo_id ASC";
                $parametros = array($publicidade->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($result = $rs->fetch(PDO::FETCH_OBJ)){
                        array_push($dados, $result);
                    }
                    return $dados;
                }else{
                    return "nenhum"; 
                }
                
            } catch (Exception $e){
                return $e->getMessage();
            }
        }
        
        public function buscaUltimoCicloPublicidade(PublicidadeModel $publicidade){
            $dados = array();
            try{
                $sql = "SELECT 
                            cl.c_ciclo_id as id,
                            cl.c_ciclo_inicio as ciclo_inicio,
                            cl.c_ciclo_fim as ciclo_fim,
                            cl.c_ciclo_status as ciclo_status,
                            cl.c_ciclo_custo as ciclo_custo
                        FROM 
                            c_ciclo as cl
                        WHERE
                            cl.c_publicidade_id = ?
                        ORDER BY
                            cl.c_ciclo_id DESC";
                $parametros = array($publicidade->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    $result = $rs->fetch(PDO::FETCH_OBJ);
                    return $result;
                }else{
                    return "nenhum"; 
                }
                
            } catch (Exception $e){
                return $e->getMessage();
            }
        }        
        
        public function deletarCiclosPublicidade(PublicidadeModel $publicidade){
            try{
                $sql = "DELETE FROM c_ciclo
                        WHERE
                        c_publicidade_id = ?";
                
                $parametros = array($publicidade->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    return "success";
                }else{
                    return "success";
                }
            } catch (Exception $e){
                return $e->getMessage();
            }
        }
        
        public function buscarPublicidadesPorGrupo(GrupoModel $grupo){
            $json = array();
            try{
                $sql = "SELECT *
                        FROM
                            c_publicidade as p,
                            c_local as l,
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            p.c_local_id = l.c_local_id AND
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            sg.c_grupo_id = g.c_grupo_id AND
                            p.c_publicidade_status = 'a' AND
                            g.c_grupo_id = ?";
                
                $parametros = array($grupo->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                $json = array("qtd" => $rs->rowCount());
                
            }catch(Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function buscarPublicidadesPorSubgrupo(SubGrupoModel $subgrupo){
            $json = array();
            try{
                $sql = "SELECT *
                        FROM
                            c_publicidade as p,
                            c_local as l,
                            c_subgrupo as sg
                        WHERE
                            p.c_local_id = l.c_local_id AND
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            p.c_publicidade_status = 'a' AND
                            sg.c_subgrupo_id = ?";
                
                $parametros = array($subgrupo->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                $json = array("qtd" => $rs->rowCount());
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }

        public function buscarQtdPublicidadesPorLocal(LocalModel $local){
            $json = array();
            try{
                $sql = "SELECT *
                        FROM
                            c_publicidade as p
                        WHERE
                            p.c_publicidade_status = 'a' AND
                            p.c_local_id = ?";
                
                $parametros = array($local->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                $json = array("qtd" => $rs->rowCount());
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }

        public function filtroPublicidades($campanha, $midia, $status){
            $json = array();
            if($midia != "TODAS"){
                $clause_midia = " p.c_midia_id = ".$midia." AND ";
            }else{
                $clause_midia = "";
            }
            if($status != "TODOS"){
                $clause_status = " p.c_publicidade_status = '".$status."' AND ";
            }else{
                $clause_status = "";
            }
            
            try{
                $sql = "SELECT
                            p.c_publicidade_id as id_publicidade,
                            p.c_publicidade_descricao as descricao,
                            p.c_publicidade_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_publicidade_status as status_publicidade,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            c.c_campanha_layout as layout_campanha,
                            p.c_local_id as id_local,
                            l.c_local_nome as nome_local,
                            sg.c_subgrupo_id as id_subgrupo,
                            sg.c_subgrupo_nome as nome_subgrupo,
                            g.c_grupo_id as id_grupo,
                            g.c_grupo_nome as nome_grupo,                            
                            p.c_pessoa_id as id_pessoa
                        FROM 
                            c_publicidade as p,
                            c_midia as m,
                            c_campanha as c,
                            c_local as l,
                            c_subgrupo as sg,
                            c_grupo as g
                        WHERE
                            ".$clause_midia."
                            ".$clause_status."
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_local_id = l.c_local_id AND
                            l.c_subgrupo_id = sg.c_subgrupo_id AND
                            sg.c_grupo_id = g.c_grupo_id AND
                            p.c_campanha_id = ?
                        ORDER BY
                            c_grupo_nome ASC,
                            c_subgrupo_nome ASC,
                            c_local_nome ASC,
                            nome_midia ASC";
                
                $parametros = array($campanha);
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        $publicidade1 = new PublicidadeModel();
                        $publicidade1->setId($dados->id_publicidade);
                        array_push($json, array(
                                        "id" => $dados->id_publicidade,
                                        "descricao" => $dados->descricao,
                                        "id_campanha" => $dados->id_campanha,
                                        "nome_campanha" => $dados->nome_campanha,
                                        "id_midia" => $dados->id_midia,
                                        "nome_midia" => $dados->nome_midia,
                                        "ambiente" => $dados->ambiente,
                                        "id_local" => $dados->id_local,
                                        "nome_local" => $dados->nome_local,
                                        "id_subgrupo" => $dados->id_subgrupo,
                                        "nome_subgrupo" => $dados->nome_subgrupo,
                                        "id_grupo" => $dados->id_grupo,
                                        "nome_grupo" => $dados->nome_grupo,
                                        "status" => $dados->status_publicidade,
                                        "layout_campanha" => $dados->layout_campanha,
                                        "id_pessoa" => $dados->id_pessoa,
                                        "ciclo" => $this->buscaUltimoCicloPublicidade($publicidade1)));
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            }catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }
        
        public function buscaPublicidadesPorMidia(MidiaModel $midia){
            $json = Array();
            try{
                $sql = "SELECT
                            p.c_publicidade_id as id_publicidade,
                            p.c_publicidade_descricao as descricao,
                            p.c_publicidade_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_publicidade_status as status_publicidade,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            c.c_campanha_layout as layout_campanha,
                            p.c_pessoa_id as id_pessoa
                        FROM 
                            c_publicidade as p,
                            c_midia as m,
                            c_campanha as c
                        WHERE
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_publicidade_status = 'a' AND
                            p.c_midia_id = ?
                        ORDER BY
                            nome_midia ASC";
                $parametros = array($midia->getId());
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        $publicidade1 = new PublicidadeModel();
                        $publicidade1->setId($dados->id_publicidade);
                        array_push($json, array(
                                        "id" => $dados->id_publicidade,
                                        "descricao" => $dados->descricao,
                                        "id_campanha" => $dados->id_campanha,
                                        "nome_campanha" => $dados->nome_campanha,
                                        "id_midia" => $dados->id_midia,
                                        "nome_midia" => $dados->nome_midia,
                                        "ambiente" => $dados->ambiente,
                                        "status" => $dados->status_publicidade,
                                        "layout_campanha" => $dados->layout_campanha,
                                        "id_pessoa" => $dados->id_pessoa,
                                        "ciclo" => $this->buscaUltimoCicloPublicidade($publicidade1)));
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }

        public function buscaPublicidadesPorAmbiente($ambiente){
            $json = Array();
            try{
                $sql = "SELECT
                            p.c_publicidade_id as id_publicidade,
                            p.c_publicidade_descricao as descricao,
                            p.c_publicidade_id as id_midia,
                            m.c_midia_nome as nome_midia,
                            p.c_publicidade_ambiente as ambiente,
                            p.c_publicidade_status as status_publicidade,
                            p.c_campanha_id as id_campanha,
                            c.c_campanha_nome as nome_campanha,
                            c.c_campanha_layout as layout_campanha,
                            p.c_publicidade_lat as latitude,
                            p.c_publicidade_long as longitude,  
                            p.c_pessoa_id as id_pessoa
                        FROM 
                            c_publicidade as p,
                            c_midia as m,
                            c_campanha as c
                        WHERE
                            p.c_campanha_id = c.c_campanha_id AND
                            p.c_midia_id = m.c_midia_id AND
                            p.c_publicidade_status = 'a' AND
                            p.c_publicidade_ambiente = ?
                        ORDER BY
                            nome_midia ASC";
                $parametros = array($ambiente);
                $rs = ConnectionFactory::getConection()->prepare($sql);
                $rs->execute($parametros);
                
                if($rs->rowCount() > 0){
                    while($dados = $rs->fetch(PDO::FETCH_OBJ)){
                        $publicidade1 = new PublicidadeModel();
                        $publicidade1->setId($dados->id_publicidade);
                        array_push($json, array(
                                        "id" => $dados->id_publicidade,
                                        "descricao" => $dados->descricao,
                                        "id_campanha" => $dados->id_campanha,
                                        "nome_campanha" => $dados->nome_campanha,
                                        "id_midia" => $dados->id_midia,
                                        "nome_midia" => $dados->nome_midia,
                                        "ambiente" => $dados->ambiente,
                                        "status" => $dados->status_publicidade,
                                        "layout_campanha" => $dados->layout_campanha,
                                        "latitude" => $dados->latitude,
                                        "longitude" => $dados->longitude,
                                        "id_pessoa" => $dados->id_pessoa,
                                        "ciclo" => $this->buscaUltimoCicloPublicidade($publicidade1)));
                    }
                }else{
                    $json = array("codigo" => 1, "message" => "nenhum");
                }
                
            } catch (Exception $e){
                $json = array("codigo" => 1, "message" => $e->getMessage());
            }
            
            header("Content-Type: application/json");
            echo json_encode($json);
        }          
}