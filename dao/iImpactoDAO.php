<?php

interface iImpactoDAO
{
    	public function save(ImpactoModel $impacto);
	public function view(ImpactoModel $impacto);
	public function listAll();
	public function delete(LocalModel $local);
	public function update(ImpactoModel $impacto);
        public function impactoPorPublicoLocal(PublicoModel $publico, LocalModel $local);
        public function impactosPorLocal(LocalModel $local);
}