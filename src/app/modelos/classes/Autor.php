<?php
	class Autor{
		function __construct($nome = " ", $idLattes = "", $ordemDeAutoria = "", $nomeEmCitacoes = ""){
			$this->nome = $nome;
			$this->idLattes = $idLattes;
			$this->ordemDeAutoria = $ordemDeAutoria; 
			$this->nomeEmCitacoes = $nomeEmCitacoes; 
		}
		function getNome(){ return $this->nome; }
		function getNomeEmCitacoes() { return $this->nomeEmCitacoes; }
		function getidLattes() { return $this->idLattes; }
		function getOrdemDeAutoria() { return $this->ordemDeAutoria; }
	
		function compara($autor){
			if($this->getNome() == $autor->getNome() &&
			$this->getIdLattes() == $autor->getIdLattes() && 
			$this->getNomeEmCitacoes() == $autor->getNomeEmCitacoes()) return true;

			return false;
		}
	}
?>	