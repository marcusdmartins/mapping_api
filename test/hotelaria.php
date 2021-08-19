<?php

class Rotina {
	public $id;
	public $nome;
	public $listaSubRotina = Array();
}

class SubRotina extends Rotina {
	public $id;
	public $nome;
	public $link;
	public $rotina;
}

class Acesso {
	public $colaborador;
	public $rotina;
	public $subrotina;
	public $inserir = false;
	public $excluir = false;
	public $pesquisar = false;
	public $alterar = false;
}

class Colaborador {
	public $id;
	public $matricula;
	public $nome;
	public $login;
	public $senha;
}

class Grupo {
	public $id;
	public $nome;
	public $listaSubGrupo = Array();

}

class Subgrupo {
	public $id;
	public $nome;
	public $listaLocais = Array();
}

class Local {
	public $id;
	public $nome;
	public $dimensao;
}

class Rota {
	public $id;
	public $descricao;
	public $status;
	public $TempoIni;
	public $TempoFin;
	public $listaLocais = Array();

}

class Tarefa {
	public $id;
	public $dataini;
	public $datafim;
	public $colaborador;
	public $historico;
	public $listaServicos = Array();
}

class Servicos {
	public $id;
	public $nome;
	public $listaProdutos = Array();
}

class Produto {
	public $nome = Array("Sontara", "Mop", "balde", "vassoura", "Roudo", "Saco de Lixo", "Pano de Chão");
}

//Factory
class Factory {

	public function fabricarASG($id, $nome, $matricula) {
		$asg = new Colaborador();
		$asg -> id = $id;
		$asg -> nome = $nome;
		$asg -> matricula = $matricula;
		return $asg;
	}

	public function fabricarGrupo($id, $nome) {
		$gp = new Grupo();
		$gp -> id = $id;
		$gp -> nome = $nome;
		return $gp;
	}

	public function fabricarSubGrupo(Grupo $gp, $id, $nome) {

		$sgp = new Subgrupo();
		$sgp -> id = $id;
		$sgp -> nome = $nome;
		array_push($gp -> listaSubGrupo, $sgp);
		return $sgp;
	}

	public function fabricarLocal($id, $nome, $dimensao, Subgrupo $sgp) {

		$lc = new Local();
		$lc -> id = $id;
		$lc -> dimensao = $dimensao;
		$lc -> nome = $nome;
		array_push($sgp -> listaLocais, $lc);
		return $lc;
	}

	public function fabricarRota($id, $descricao, $status, $t1, $t2, $lc) {
		$rt = new Rota();
		$rt -> id = $id;
		$rt -> descricao = $descricao;
		$rt -> TempoIni = $t1;
		$rt -> TempoFin = $t2;
		$rt -> status = $status;
		array_push($rt -> listaLocais, $lc);
		return $rt;
	}

	public function gerarTarefa($id, $dataIni = "", $dataFin = "", Colaborador $colaborador, $historico = "") {

		$trf = new Tarefa();
		$trf -> colaborador = $colaborador;
		$trf -> dataini = $dataIni;
		$trf -> datafim = $dataFin;
		$trf -> historico = $historico;

		return $trf;

	}

	public function fabricarServico($id, $nome, $ini, $fim) {
		$srv = new Servicos();
		$srv -> id = $id;
		$srv -> nome = $nome;

		$produto = new Produto();
		for ($i = $ini; $i < $fim; $i++) {
			array_push($srv -> listaProdutos, $produto -> nome[$i]);
		}
		return $srv;
	}

}

/*
 $factory = new Factory();

 $asg = $factory -> fabricarASG(1, "Fulano da Silva", "22312");
 $grupo = $factory -> fabricarGrupo(1, "Subsolo");
 $subgrupo = $factory -> fabricarSubGrupo($grupo, 1001, "Vestiarios");
 $locais = array(
 $factory->fabricarLocal(1,"Vestiario Feminino", 37.5, $subgrupo),
 $factory->fabricarLocal(2,"Vestiario Masculino", 35.5, $subgrupo),
 $factory->fabricarLocal(3,"Rouparia Limpa", 62.5, $subgrupo)
 );
 $rota = $factory->fabricarRota(1, "RT_SB_0001", "ok", "07:00", "13:00", $locais);

 $json = array("asg" => $asg, "grupo"=>$grupo,"rota" => $rota);
 header('Content-Type: application/json');
 echo json_encode(array("result" => $json));
 */
