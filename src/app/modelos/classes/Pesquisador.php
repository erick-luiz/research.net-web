<?php
	
	include_once "Curriculo.php";
	
	class Pesquisador{
		function __construct($caminhoCurriculoXml){
			$this->curriculo = new Curriculo($caminhoCurriculoXml);	
			$this->idLattes = $this->curriculo->getIdentificador();
			$this->nome = $this->curriculo->getNome();
			$this->nomesCitacoes = $this->curriculo->getNomeCitacoes(); 
		}
		// Get's do Curriculo
		function getNome(){ return $this->nome; }
		function getIdLattes(){ return (string)$this->idLattes; }
		function getDataAtualizacao(){ return $this->curriculo->getDataAtualizacao(); }
		
		function getAnosDeProducao(){
			$anos = $this->curriculo->getAnosDeProducao();
			return $anos;
		}
		function getProducoesDoAno($ano){
			$retorno = []; 
			foreach ($this->curriculo->getProducoes() as $producao){
				if($producao->getAno() == $ano) $retorno[] = $producao;
			}
			return $retorno; 
		}
		function getNumeroProducoesDoAno($ano){
			$retorno = 0; 
			foreach ($this->curriculo->getProducoes() as $producao){
				if($producao->getAno() == $ano) $retorno++;
			}
			return $retorno; 
		}
		function getProducoes(){ return $this->curriculo->getProducoes(); }
		function getNumeroDeProducoes(){ return count($this->curriculo->getProducoes()); }
		/*
		* Retorna o número de produções do pesquisador que não foram identificadas 
		* como duplicata na rede 
		*/
		function getNumeroDeProducoesNaoDuplicatas($ano){
			$producoes = $this->getProducoesDoAno($ano);
			$contador = 0;
			foreach ($producoes as $producao) {
				if($producao->getIdDuplicata() == null) $contador++; 
			}
			return $contador; 
		}
	}
?>