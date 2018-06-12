<?php

	include_once "classes/Rede.class.php";
	include_once "classes/Pesquisador.php";
	include_once "classes/Duplicata.class.php";
	include_once "persistencia/RedesDAO.class.php";
	include_once "persistencia/PesquisadoresDaRedeDAO.class.php";


	class ConstrutorDeRedes{
				
		function __construct(){}

		function servico($request = ["idResearcher" => "9414212573217453"], $resposta = null){

			//print_r($_POST);
			$idResearcher = $_POST["idResearcher"];

			try{
 
				if(!(array_key_exists("idResearcher", $request))){
					//$resposta->setResposta("paginaDeErros","pesquisadores da Rede não definidos!");
				} 

				$research =  new Pesquisador("..\\arquivos\\xml\\pesquisadores\\".$idResearcher.".xml");

				$years = array_unique($research->getAnosDeProducao());
				sort($years);
				
				$productions = [];
				$productions['years'] = $years; 
				foreach ($years as $year) {
					$aux = [];
					foreach ($research->getProducoesDoAno($year) as $production) {
						$aux[] =  $production->getTituloEstruturado();
					}
					$productions[$year] = $aux;
				}

				echo(json_encode($productions));
				/*$productions = []; 
				foreach ($research->getProducoes() as $key => $production) {
					
					echo($production->getTituloEstruturado() . "<br>"); 
					echo($key . "<br>");
				}*/



				// print_r($research->getProducoes());
				

				
					
					/*# Monta a rede, pois neste bloco assumimos que a mesma não existe 
					$rede = new Rede($requisicao["titulo"],$pesquisadoresDaRede[0], $pesquisadoresDaRede[1],$requisicao['metric'],$requisicao['min_similarity']);
					$pesquisadoresDaRedeParaCadastro = $pesquisadoresDaRede;
					array_shift($pesquisadoresDaRede);
					array_shift($pesquisadoresDaRede);
					
					foreach ($pesquisadoresDaRede as $pesquisador) {
						$rede->addPesquisador($pesquisador);
					}

					$dao->cadastraRede($rede);
					$idRede = $dao->idUltimoRegistro();
					

					$dao2->cadastraPesquisadoresDaRede($pesquisadoresDaRedeParaCadastro,$idRede);
					$rede->geraXml("rede".$idRede, "..\\arquivos\\XML\\redes\\");
					$resposta->setResposta("index", "");*/
				/*}

				$dao2->fechaConexao();
				$dao->fechaConexao();*/
			}catch(Exception $e){
				$resposta->setResposta("paginaDeErros", $m." ". $e->getMessage());
			}
		}
	}

	$c = new ConstrutorDeRedes();
	$c->servico();

?>