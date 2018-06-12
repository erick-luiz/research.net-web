<?php 
	class Duplicata{
		private static $identificador = 0;

		function __construct($ano){
			self::$identificador++;
			$this->numeroDeAutores = 2;
			$this->ano = $ano;
			$this->id = self::$identificador;
		}
		
		function getId(){ return $this->id;}
		function getNumeroDeAutores(){ return $this->numeroDeAutores;}
		function getAno(){ return $this->ano;}
		function addAutor(){ $this->numeroDeAutores++; }
	}
?>