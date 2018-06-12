<?php
	
	class Nodo{
		function __construct($idLattes, $nome, $numeroDeProducoes, $dataAtualizacao){
			$this->id = $idLattes; 
			$this->label = $nome; 
			$this->numeroDeProducoes = $numeroDeProducoes; 
			$this->dataAtualizacao = $dataAtualizacao; 
			$this->producoes = [];
			$this->numeroDeProducoesPorAno = [];
		}
		function addProducao($producao){ 
			$producaoArray["titulo"] = $producao->getTituloEstruturado();
			$ano = $producao->getAno();
			$producaoArray["ano"] = $ano;
			$producaoArray["idAresta"] = $producao->getIdDuplicata();
			$this->producoes[] = $producaoArray;

			if(!(array_key_exists($ano, $this->numeroDeProducoesPorAno))){
				$this->numeroDeProducoesPorAno[$ano] = 0;
			}
			$this->numeroDeProducoesPorAno[$ano]++;
		}
		function getXML(){
			$retorno = "<nodo>\n";
			$retorno .= "\t\t\t<id>".$this->id."</id>\n";
			$retorno .= "\t\t\t<label>".$this->label."</label>\n";
			$retorno .= "\t\t\t<dataAtualizacao>".$this->dataAtualizacao."</dataAtualizacao>\n";
			$retorno .= "\t\t\t<numeroDeProducoes>".$this->numeroDeProducoes."</numeroDeProducoes>\n";

			$retorno .= "\t\t\t<numeroDeProducoesPorAno>\n";
			foreach ($this->numeroDeProducoesPorAno as $ano => $numero){
				$retorno .= "\t\t\t\t<ano value=\"$ano\">$numero</ano>\n";
			}
			$retorno .= "\t\t\t</numeroDeProducoesPorAno>\n";


			$retorno .= "\t\t\t<producoes>\n";
			foreach ($this->producoes as $producao){
				$retorno .= "\t\t\t\t<producao>\n";
				$retorno .= "\t\t\t\t\t<titulo>".$producao["titulo"]."</titulo>\n";
				$retorno .= "\t\t\t\t\t<ano>".$producao["ano"]."</ano>\n";
				$retorno .= "\t\t\t\t\t<idAresta>".$producao["idAresta"]."</idAresta>\n";
				$retorno .= "\t\t\t\t</producao>\n";
			}
			$retorno .= "\t\t\t</producoes>\n";
			$retorno .= "\t\t</nodo>\n";
			return $retorno;
		}
	}
?>