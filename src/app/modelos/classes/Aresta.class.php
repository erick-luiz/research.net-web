<?php
	
	class Aresta{
		private $autor1, $autor2, $duplicatas = []; 
		function __construct($autor1, $autor2){
			$this->autor1 = $autor1; 
			$this->autor2 = $autor2;
			// Array associativo que dará peso por ano de ocorrência 
			$this->pesoPorAno = [];
			// Array de duplicatas de determinado ano
			$this->duplicatas = [];
			// $this->ano = $ano;
			$this->peso = 0;
		}
		function getAutor1(){return $this->autor1;}
		function getAutor2(){return $this->autor2;}
		function getDuplicatas(){return $this->duplicatas;}
		function getAno(){return $this->ano;}

		function addDuplicata($idDuplicata, $ano, $levenshtein, $titulo1, $titulo2){
			$duplicata['id'] = $idDuplicata;
			$duplicata['ano'] = $ano;
			$duplicata['levenshtein'] = $levenshtein;
			$duplicata['titulo1'] = $titulo1;
			$duplicata['titulo2'] = $titulo2;
			$this->duplicatas[$ano][] =  $duplicata;
		}

		function verificaAresta($autor1, $autor2){
			// Verficação entre arestas de mesmo pesquisadores.
			if(($this->autor1 == $autor1 && $this->autor2 == $autor2)||($this->autor1 == $autor2 && $this->autor2 == $autor1)){
				return true; 
			}
			return false;
		}
		function verificaExistenciaDaDuplicata($idDuplicata, $ano){
			foreach ($this->duplicatas[$ano] as $duplicata) {
				if($duplicata["id"] == $idDuplicata) return true;
			}
			return false;
		}
		function getXML(){
			$retorno = "\t\t<aresta>\n";
			$retorno .= "\t\t\t\t<autor1>".$this->autor1."</autor1>\n";
			$retorno .= "\t\t\t\t<autor2>".$this->autor2."</autor2>\n";
			$retorno .= "\t\t\t\t<anos>\n";
			
			foreach ($this->duplicatas as $ano => $duplicatasDoAno){
				$retorno .= "\t\t\t\t<ano valor=\"".$ano."\">\n";
				$retorno .= "\t\t\t\t\t<duplicatas>\n";
				foreach ($duplicatasDoAno as $duplicata) {
					$retorno .= "\t\t\t\t\t\t<duplicata>\n";
					$retorno .= "\t\t\t\t\t\t<id>".$duplicata['id']."</id>\n";
					$retorno .= "\t\t\t\t\t\t<indice>".$duplicata['levenshtein']."</indice>\n";
					$retorno .= "\t\t\t\t\t\t<titulo1>".$duplicata['titulo1']."</titulo1>\n";
					$retorno .= "\t\t\t\t\t\t<titulo2>".$duplicata['titulo2']."</titulo2>\n";
					$retorno .= "\t\t\t\t\t\t</duplicata>\n";
					//.$duplicata['id']."</duplicata>\n";	
				}
				$retorno .= "\t\t\t\t\t</duplicatas>\n";
				$retorno .="\t\t\t\t\t<peso>".count($duplicatasDoAno)."</peso>\n"; 
				$retorno .= "\t\t\t\t</ano>\n";
			}
			
			$retorno .= "\t\t\t\t</anos>\n";
			$retorno .= "\t\t\t</aresta>\n";
			return $retorno;
		}
	}
?>