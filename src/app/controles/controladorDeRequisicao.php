<?php
	
	include_once "controladorDeRespostas.php";

	function responde($resposta){
		if($resposta->getMetodo() == "GET"){
			header("location:".$resposta->getURL()); 
		}else if($resposta->getMetodo() == "JSON"){
			echo $resposta->getDados();
		}
	}

	$resposta = new ControladorDeRespostas();

	if($_SERVER['REQUEST_METHOD'] == "GET"){
		$requisicao = isset($_GET["requisicao"])? $_GET["requisicao"]:false; 
	}else{
		$requisicao = isset($_POST["requisicao"])? $_POST["requisicao"]:false;
	}
	
	// Caso a requisição não tenha sido definida
	if($requisicao){
		
		// Monta URL e tranforma a consulta GET em um array 
		// neste array as cavhes são os parametros

		if($_SERVER['REQUEST_METHOD'] == "GET"){
			$url = parse_url("http:/".$_SERVER['REQUEST_URI']);
			parse_str($url['query'], $dadosDaRequisicao);
		}else{
			$dadosDaRequisicao = $_FILES["curriculoXML"];
		}
		
		// Instância a classe da requisição dinamicamente
		// Toda classe de modelo irá receber a requisição em string 
		// Em seguida deve desmontar e pegar o que deseja da requisição 
		//$class = ucfirst(strtolower($_GET['requisicao']));    
  		$class = $requisicao;
  		include "../modelos/".$class . ".class.php";
    	(new $class())->servico($dadosDaRequisicao, $resposta);

	}else{
		$resposta->setResposta("paginaDeErros", "Não Foi possivel completar a requisição, tente novamente ou entre em contato com os administradores do site ");
	}
	responde($resposta);
?>