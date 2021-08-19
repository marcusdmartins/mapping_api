<?php

class Fabricante {
	public $id;
	public $nome;
	public $listaVeiculos = Array();
}

class Veiculo {
	public $id;
	public $cor;
	public $modelo;
	public $ano;
}

class Usuario {
	public $id;
	public $nome;
	public $cpf;
}

class Endereco {
	public $id;
	public $logradouro;
	public $cidade;
	public $uf;
}

class Locacao {
	public $usuario;
	public $data;
	public $veiculo;
}

class Factory {

	public function fabricaFabricante() {

		$fabricante = new Fabricante();
		$fabricante -> id = 1;
		$fabricante -> nome = "Fiat";
		return $fabricante;
	}

	public function fabricaUsuario() {

		$usuario = new Usuario();
		$usuario -> id = 2001;
		$usuario -> cpf = "999.999.999-00";
		$usuario -> nome = "Amigo Feitosa";
		return $usuario;
	}

	public function locarVeiculo() {

		$cliente = $this -> fabricaUsuario();
		$data = date("d/m/y");

		$fabricante = $this -> fabricaFabricante();
		$veiculo = new Veiculo();
		$veiculo -> id = 1;
		$veiculo -> cor = "#FFFF00";
		$veiculo -> modelo = "Celta";
		$veiculo -> ano = 2001;

		array_push($fabricante -> listaVeiculos, $veiculo);

		$veiculo = new Veiculo();
		$veiculo -> id = 2;
		$veiculo -> cor = "#FFFF00";
		$veiculo -> modelo = "Corsa";
		$veiculo -> ano = 2008;

		array_push($fabricante -> listaVeiculos, $veiculo);

		$json = array("cliente" => $cliente, "data" => $data, "fabricante" => $fabricante);
		header('Content-Type: application/json');
		echo json_encode(array("result" => $json));
	}

}

$testa = new Factory();
$testa -> locarVeiculo();
