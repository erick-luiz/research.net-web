<?php
	
	include "XML.class.php";
	include "TrabalhoEmEventos.class.php";

	class Curriculo{
		
		function __construct($caminho){
			$curriculoXML = new XML($caminho);
			$this->curriculo = $curriculoXML->getArray();
			$this->listaDeProducoes = []; 
			$this->anosDeProducao = [];
			$this->setTrabalhosEmEventos();
			$this->numeroDeProducoes = 0;
		}
		// Getters do Curriculo
		function getIdentificador(){ return $this->curriculo["@attributes"]["NUMERO-IDENTIFICADOR"];}
		function getDataAtualizacao(){ return $this->curriculo["@attributes"]["DATA-ATUALIZACAO"]; }
		function getProducoes(){return $this->listaDeProducoes; }
		function getNome(){	return $this->curriculo["DADOS-GERAIS"]["@attributes"]["NOME-COMPLETO"]; }
		function getNomeCitacoes(){ return $this->curriculo["DADOS-GERAIS"]["@attributes"]["NOME-EM-CITACOES-BIBLIOGRAFICAS"];}
		function getAnosDeProducao(){ return $this->anosDeProducao;}

		private function setTrabalhosEmEventos(){
			if(!array_key_exists("PRODUCAO-BIBLIOGRAFICA",$this->curriculo)) return false;
			if(array_key_exists("TRABALHOS-EM-EVENTOS", $this->curriculo["PRODUCAO-BIBLIOGRAFICA"])){
				$trabalhosEmEventos= $this->curriculo["PRODUCAO-BIBLIOGRAFICA"]["TRABALHOS-EM-EVENTOS"];
			
				if(array_key_exists("TRABALHO-EM-EVENTOS", $trabalhosEmEventos)){
					foreach ($trabalhosEmEventos["TRABALHO-EM-EVENTOS"] as $trabalho) {
						
						$novotrabalho = new TrabalhoEmEventos();
						$novotrabalho->setDadosBasicos($trabalho["DADOS-BASICOS-DO-TRABALHO"]["@attributes"]);
						$novotrabalho->setDetalhamento($trabalho["DETALHAMENTO-DO-TRABALHO"]["@attributes"]);
						if(array_key_exists("AUTORES", $trabalho)){ 
							$novotrabalho->setListaDeAutores($trabalho["AUTORES"]);
						}
						if(array_key_exists("PALAVRAS-CHAVE", $trabalho)){
							$novotrabalho->setPalavrasChave($trabalho["PALAVRAS-CHAVE"]["@attributes"]);
						}
						if(array_key_exists("AREAS-DO-CONHECIMENTO", $trabalho)){
							$novotrabalho->setAreasDoConhecimento($trabalho["AREAS-DO-CONHECIMENTO"]);
						}
						if(!array_key_exists($novotrabalho->getAno(), $this->anosDeProducao)){
							$this->anosDeProducao[] = $novotrabalho->getAno();
						}
						$this->listaDeProducoes[] = $novotrabalho;
					}
					asort($this->anosDeProducao);
				}	
			}
		}
	}
?>