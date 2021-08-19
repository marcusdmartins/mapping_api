<?php

interface iPublicoDAO
{
    	public function save(PublicoModel $publico);
	public function view(PublicoModel $publico);
	public function listAll();
	public function delete(PublicoModel $publico);
	public function update(PublicoModel $publico);
        public function publicoPorCampanha(CampanhaModel $campanha);
        public function mediaImpactoCampanha(CampanhaModel $campanha, PublicoModel $publico);
        public function somaImpactoCampanha(CampanhaModel $campanha, PublicoModel $publico);
}