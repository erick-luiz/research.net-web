<?php 
	class XML{

		function __construct($caminho){
			$this->caminho = $caminho;
			$this->abreArquivoXml($caminho);
			$this->arrayXml = $this->xmlParaArray($this->xml); 
		}
		# Get's da classe XML 
		function getCaminho(){ return $this->caminho; }
		function getArray(){ return $this->arrayXml; }
		function abreArquivoXml(){ $this->xml = simplexml_load_file($this->getCaminho()); }

		# Recebe um arquivo xml e retorna um array 
		function xmlParaArray( $xml ,$out = array()){

			foreach ((array)$xml as $chave => $valor){
	           $out[$chave] = (is_object($valor)||is_array($valor))?$this->xmlParaArray($valor):$valor;
	        }
	        return $out;
		}	
	}
?>