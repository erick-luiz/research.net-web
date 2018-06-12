<?php

	include_once "Rede.class.php";
	include_once "Pesquisador.php";
	include_once "Duplicata.class.php";
	include_once "../persistencia/RedesDAO.class.php";
	include_once "../persistencia/PesquisadoresDaRedeDAO.class.php";


	class ConstrutorDeRedes{
				
		function __construct(){}

		function servico(){

			try{

				# Monta um array com os id's dos lattes dos pesquisadores, são os nomes dos arquivos dos curriculos
				$p = "8252864210379656;7250395159742188;5851601274050374;3528633359332021";
				$pesquisadores = explode(";",$p);

				$pesquisadoresDaRede = [];
				for ($i = 0; $i < count($pesquisadores); $i++){
					if($pesquisadores[$i] == "") {
						unset($pesquisadores[$i]);
						continue; 
					}
					$pesquisadoresDaRede[] = new Pesquisador("..\\..\\arquivos\\xml\\pesquisadores\\".$pesquisadores[$i].".xml");
				}

				if(count($pesquisadoresDaRede) < 2)
					echo("Numero de pesquisadores insuficiente para a construção da rede");

				# Verifica se já existe uma rede com os mesmos pesquisadores 
				$dao2 = new pesquisadoresDaRedeDAO(); 
				$redesEmComum = [];
				$primeiroEvento = true;
				foreach ($pesquisadoresDaRede as $pesquisador) {
					echo("<br />Nome:" . $pesquisador->getNome());
					echo("<br />Redes:");
					print_r($dao2->getRedesDoPesquisador($pesquisador));
					if(!$primeiroEvento){
						//print_r($redesEmComum);
						//echo("<br>");
						$redesEmComum = array_intersect($redesEmComum, $dao2->getRedesDoPesquisador($pesquisador));
					}else{
						$redesEmComum = $dao2->getRedesDoPesquisador($pesquisador);
						$primeiroEvento = false; 
					}
				}
				echo("<br>");
				print_r($redesEmComum);
				$redeExistente = false;
				
				# Pega o nome da rede já criada 
				$dao = new RedesDAO(); 
				if(count($redesEmComum) != 0){
					foreach ($redesEmComum as $redeEmComum) {
						$nPesquisadores = $dao->getRede($redeEmComum)["numero_pesquisadores"];
						if($nPesquisadores == count($pesquisadoresDaRede)){
							echo ("Rede já existe");
							$redeExistente = true;
							break;
						}
					}
				}

					//$rede = $dao->getRede(array_shift($redesEmComum));
					//$titulo = $rede["Titulo"] == ""? "não informado": $rede["Titulo"];
					//print_r($rede);
					//echo("paginaDeErros", "A rede de titulo: ".$titulo." foi construida em: ".$rede["data_criacao"]);
					//echo("paginaDeErros", "A rede de titulo: ".$titulo." foi construida em: ".$rede["data_criacao"]);
					//throw new Exception("Erro ao procurar por redes em comum");
				if($redeExistente){
					echo("A rede já existe ");
				}else{
					
					# Monta a rede, pois neste bloco assumimos que a mesma não existe 
					$rede = new Rede("lallala",$pesquisadoresDaRede[0], $pesquisadoresDaRede[1]);
					$pesquisadoresDaRedeParaCadastro = $pesquisadoresDaRede;
					array_shift($pesquisadoresDaRede);
					array_shift($pesquisadoresDaRede);
					
					foreach ($pesquisadoresDaRede as $pesquisador) {
						$rede->addPesquisador($pesquisador);
					}
					
					echo $dao->cadastraRede($rede);
					
					$idRede = $dao->idUltimoRegistro();
					

					$dao2->cadastraPesquisadoresDaRede($pesquisadoresDaRedeParaCadastro,$idRede);
					$rede->geraXml("rede".$idRede, "..\\..\\arquivos\\XML\\redes\\");
					//$resposta->setResposta("index", "");
				}

				$dao2->fechaConexao();
				$dao->fechaConexao();
			}catch(Exception $e){
				echo $e->getMessage();
				//$resposta->setResposta("paginaDeErros", $m." ". $e->getMessage());
			}
		}
	}

	$c = new ConstrutorDeRedes();
	$c->servico();
?>