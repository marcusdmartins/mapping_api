<?php

interface iCampanhaDAO
{
    	public function save(CampanhaModel $campanha);
	public function view(CampanhaModel $campanha);
	public function listAll();
	public function delete(CampanhaModel $campanha);
	public function update(CampanhaModel $campanha);
        public function updateLayout(CampanhaModel $campanha);
        public function inserePublico(CampanhaModel $campanha, PublicoModel $publico);
        public function deletarPublicos(CampanhaModel $campanha);
        public function validaPublicoCampanha(PublicoModel $publico, CampanhaModel $campanha);
        public function buscaPublicosPorCampanha(CampanhaModel $campanha);
        public function buscaProximasCampanhas();
        public function buscaCampanhasEmAndamento();
        public function custoPorCampanha(CampanhaModel $campanha);
        public function buscaCampanhaPorAmbiente($ambiente);
        public function buscaCampanhaInst($busca, $ambiente);
}