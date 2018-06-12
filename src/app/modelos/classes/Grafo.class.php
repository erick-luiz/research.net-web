<?php
	
	include_once "Nodo.class.php";
	include_once "Aresta.class.php";

	class Grafo{
	private $nodos = [], $arestas = [];
	function __construct($titulo){
		$this->titulo = $titulo;
		$this->anos = [];
		$this->numeroDeProducoesUnicas = 0;
		$this->numeroDeProducoesUnicasPorAno = [];
	}

	function addAno($ano){ $this->anos[] = $ano; }
	function getNumeroDeNodos(){ return count($this->nodos); }
	function getNumeroDeArestas(){ return count($this->arestas); }
	function getArestas(){ return $this->arestas; }
	
	function getArestasDoAno($ano){
		$retorno = [];
		foreach ($this->arestas as $aresta) {
			if($aresta->getAno() == $ano) $retorno[] = $aresta;
		}
		return  $retorno;
	}
	function getArestaDe($pesquisadorA, $pesquisadorB){
		foreach ($this->arestas as $aresta) {
			if($aresta->verificaAresta($pesquisadorA->getIdLattes(),$pesquisadorB->getIdLattes())) return $aresta;
		}
		$aresta = new Aresta($pesquisadorA->getIdLattes(), $pesquisadorB->getIdLattes());
		$this->arestas[] = $aresta; 
		return $aresta;
	}
	function addNodo($pesquisador){
		$nodo = new Nodo(
				$pesquisador->getIdLattes(),
				$pesquisador->getNome(),
				$pesquisador->getNumeroDeProducoes(),
				$pesquisador->getDataAtualizacao()
			);
		foreach ($pesquisador->getProducoes() as $producao) {
			$nodo->addProducao($producao);			
		}
		$this->nodos[] = $nodo; 
	}
	function setNumeroDeProducoesUnicas($valor){ $this->numeroDeProducoesUnicas = $valor; }
	function setNumeroDeProducoesUnicasPorAno($arrayProducoesUnicas){
		$this->numeroDeProducoesUnicasPorAno = $arrayProducoesUnicas; 
	}
	function setAnos($anos){ $this->anos = $anos; }

	function getXML($similaridadeMin, $metric){
		$retorno = "<?xml version='1.0' encoding='UTF-8'?>";
		$retorno .= "<grafo>\n";
		$retorno .= "\t<titulo>".$this->titulo."</titulo>\n";
		$retorno .= "\t<numeroDeProducoesUnicas>".$this->numeroDeProducoesUnicas."</numeroDeProducoesUnicas>\n";
		$retorno .= "\t<numeroDeNodos>".$this->getNumeroDeNodos()."</numeroDeNodos>\n";
		$retorno .= "\t<numeroDeArestas>".$this->getNumeroDeArestas()."</numeroDeArestas>\n";
		$retorno .= "\t<similaridadeMin>".$similaridadeMin."</similaridadeMin>\n";
		$retorno .= "\t<metrica>".$metric."</metrica>\n";
		$retorno .= "\t<anos>\n";

		foreach ($this->anos as $ano) {
			$retorno .= "\t\t<ano valor=\"".$ano."\">\n";
			$retorno .= "\t\t\t<numero-producoes>".$this->numeroDeProducoesUnicasPorAno[$ano]."</numero-producoes>\n";
			$retorno .= "\t\t</ano>\n";
		}
		$retorno .= "\t</anos>\n";
		

		$retorno .= "\t<nodos>\n";
		foreach ($this->nodos as $nodo) {$retorno .= "\t\t".$nodo->getXML();}
		$retorno .= "\t</nodos>\n";
		
		$retorno .= "\t\t<arestas>\n";
		foreach ($this->getArestas() as $aresta) {
			$retorno .= "\t".$aresta->getXML();
		}
		$retorno .= "\t\t</arestas>\n";
		$retorno .= "</grafo>\n";
		return $retorno;
	}
}

?>