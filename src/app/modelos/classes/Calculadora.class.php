<?php
	class CalculadoraDaRede{
		private static $instancia = null;
		private function __construct(){}
		function getCalculadora(){
			if(self::$instancia == null) self::$instancia = new CalculadoraDaRede();
			return self::$instancia;
		}

		function calculaProducoesUnicasPorAno($producoesDoAno, $numeroDeDuplicatasDoAno){
			$contador = 0; 
			foreach ($producoesDoAno as $producao) {
				if($producao->getDuplicata() == null) $contador++;
			}
			return $contador + $numeroDeDuplicatasDoAno;
		}

		function Similarity($string1, $string2, $metric){
			if(strtoupper($metric) == "JACCARD"){
				return $this->JACCARD($string1, $string2);
			}else{
				return $this->LEVENSHTEIN($string1, $string2);
			}

		}

		/** 
			* Implementation of the algorithm of JACCARD SIMILARITY 
			* @author Érick Lopes <si.erickluiz@gmail.com> 
			* @version 0.1 
		*/ 
		function JACCARD($string1, $string2){
			
			if(is_string($string1) && is_string($string2)){
				
				// Change the strings for array 
				$arrString1 = explode(" ", $string1);
				$arrString2 = explode(" ", $string2);

				// Counts the number of words different in the union the of arrays
				$contUnion = count(array_unique(array_merge($arrString1, $arrString2)));

				$contUnion = count(array_unique(array_merge($arrString1, $arrString2)));

				// Counts the number of words in the intersect the of arrays
				$contIntersect = count((array_intersect($arrString1, $arrString2)));
				$ret = $contUnion != 0 ? $contIntersect/$contUnion : 0;
				
				if($ret > 1)
					return 1;
				return ($ret);

			}
			// Return 0 because if in the 'IF' give a error also returns this value 
			return 0; 
		}

		function LEVENSHTEIN($string1, $string2){

			// verifica se os parâmetros que foram passados são strings 
			if(is_string($string1) && is_string($string2) && strlen($string1) <= 255 && strlen($string2) <= 255){

				$tamanhoMaior = strlen($string1) > strlen($string2)? strlen($string1) : strlen($string2);

				// Calcula o número de edição dividido pelo maior número de caracteres 
				$tamanhoMaior = $tamanhoMaior > 0? $tamanhoMaior : 0.01;
				return round(1 - levenshtein($string1, $string2)/$tamanhoMaior,2);
			}else{
				return 0;
			}
		}
	}
?>