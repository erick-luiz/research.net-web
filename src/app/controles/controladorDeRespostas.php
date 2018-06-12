<?php
	/**
	*	Classe utilizada para controlar as respostas dos modelos 
	*	Todo modole deve avisar para qual pagina quer ir 
	*	E também deve dizer (caso exista) qual erro ocorreu
	**/
	class controladorDeRespostas{
		private $erro, $pagina, $dados; 
		function __construct( $pagina = "index", $mensagem = ""){
			$this->pagina = $pagina;
			$this->mensagem = $mensagem;
			$this->dados = [];
			$this->metodo = "GET";
		}
		/*
		* Este método irá montar a URL para que o controlador possa chamar a view responsavel por 
		* renderizar a resposta da requisição feita pelo usuário 
		*/
		function getMetodo(){
			return $this->metodo;
		}
		function getURL(){
			if($this->mensagem != "") 
				return "../../../".$this->pagina.".php?mensagem=".$this->mensagem;
			if($this->dados) 
				return "../../../".$this->pagina.".php?dados=".$this->dados;
			if($this->rede)
				return "../../../".$this->pagina.".php?rede=".$this->rede;
			return "../../../".$this->pagina.".php";		
		}
		function getDados(){
			return $this->dados;
		}

		function setResposta($pagina, $mensagem = ""){
			$this->pagina = $pagina;
			$this->mensagem = $mensagem; 
		}
		function setDados($dados){
			$this->dados = $dados;
		}
		function setRede($rede){
			$this->rede = $rede;
		}
		function setMetodo($metodo){
			$this->metodo = $metodo;
		}
	}
?>