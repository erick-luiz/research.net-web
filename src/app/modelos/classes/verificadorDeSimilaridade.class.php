<?php

	include_once("Calculadora.class.php");
	/**
	* Classe utilizada para fazer verificações da similaridade entre duas strings 
	* Pode retornar erros para os casos: 
	* 1 - Não recebeu duas strings 
	* 2 - o número de caracteres de uma das strings é maior que 255 
	* ou a porcentagem de igualdade entre as mesma sendo 1 para igual 
	* e 0 para diferente
	*/
	class VerificadorDeSimilaridade{
		// Utilizada para guardar uma instância do Verificador 
		private static $verificador = false;
		// Construtor privato para garantia que só seja construido na classe 
		private function __construct(){
			$this->calc = CalculadoraDaRede::getCalculadora();
		}
		
		// Retorna uma instância de verificador para a aplicação 
		function getVerificador(){
			if(!self::$verificador) $verificador = new VerificadorDeSimilaridade();
			return $verificador;
		}

		// Retorna uma porcentagem de igualdade de duas strings 
		// 1 para igual e 0 para diferente 
		function equivalenciaDeStrings($string1, $string2, $metric){
			if($metric == "JACCARD"){
				return $this->calc->JACARD($string1, $string2);
			}else{
				return $this->calc->LEVENSHTEIN($string1, $string2);
			}

		}
	}
?>