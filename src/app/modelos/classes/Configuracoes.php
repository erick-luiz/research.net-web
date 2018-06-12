<?php
	class Configuracao{
				
		private function __construct(){}

		### Configurações do Banco de dados 
		public static function getLocalDB(){ return "localhost"; }
		public static function getNomeDB(){ return "research.net"; }
		public static function getUsuarioDB(){ return "root"; }
		public static function getSenhaDB(){ return ""; }

		public static function getDiretorioDeCurriculos() { return "/arquivos/xml"; }
	}
?>