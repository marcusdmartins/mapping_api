<?php

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
	public $nome = Array("Sontara", "Mop", "balde", "vassoura", "Roudo", "Saco de Lixo", "Pano de Chao");
}


//criando o colaborador
$colaborador = new Colaborador();
$colaborador -> id = 1;
$colaborador -> nome = "Fulano da Silva";
$colaborador -> matricula = 12345;

//criando o grupo
$grupo = new Grupo();
$grupo -> id = 1;
$grupo -> nome = "Primeiro 1";

//criando o sublocal
$subgrupo = new Subgrupo();
$subgrupo -> id = 1;
$subgrupo -> nome = "hemodialise";

array_push($grupo -> listaSubGrupo, $subgrupo);
//vincular o subgrupo ao seu grupo

//criando o local
$local = new Local();
$local -> id = 1;
$local -> nome = "Leito 01";
$local -> dimensao = 30.5;
array_push($subgrupo -> listaLocais, $local);
//vincula o local ao seu subgrupo

$local -> id = 2;
$local -> nome = "Leito 02";
$local -> dimensao = 30.5;
array_push($subgrupo -> listaLocais, $local);
//vincula o local ao seu subgrupo

//criando a rota
$rota = new Rota();
$rota -> id = 1;
$rota -> TempoIni = "7:00";
$rota -> TempoIni = "13:00";

array_push($rota -> listaLocais, $subgrupo -> listaLocais);

$servico = new Servicos();
$servico -> id = 1;
$servico -> nome = "Limpeza Terminal";

$produto = new Produto();
for ($i = 0; $i < count($produto -> nome); $i++) {
	$qtd = mt_rand(1, 10);
	array_push($servico -> listaProdutos, array("produto" => $produto -> nome[$i], "qtde" => $qtd));
}

//criando a atividade
$atividade = new Tarefa();
$atividade -> id = 1;
$atividade -> colaborador = $colaborador;

//vincula o servico a atividade
array_push($atividade -> listaServicos, $servico);


//$json = array("asg" => $colaborador,"local"=>$local,"servico"=>$servico,"atividade"=>$atividade);
$json = array("rota"=>$rota,"atividade"=>$atividade);

header('Access-Control-Allow-Origin: *');
header("Content-Type: text/html; charset=UTF-8", true);
header('Content-Type: application/json');

echo json_encode(array("result" => $json));
