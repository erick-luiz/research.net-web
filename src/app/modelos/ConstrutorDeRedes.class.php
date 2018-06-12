<?php

	include_once "classes/Rede.class.php";
	include_once "classes/Pesquisador.php";
	include_once "classes/Duplicata.class.php";
	include_once "persistencia/RedesDAO.class.php";
	include_once "persistencia/PesquisadoresDaRedeDAO.class.php";


	class ConstrutorDeRedes{
				
		function __construct(){}

		function servico($requisicao, $resposta){

			try{

				# Garante que os pesquisadores vieram como parâmetro de requisição GET 
				if(!(array_key_exists("pesquisadores", $requisicao))){
					$resposta->setResposta("paginaDeErros","pesquisadores da Rede não definidos!");
				} 

				# Monta um array com os id's dos lattes dos pesquisadores, são os nomes dos arquivos dos curriculos 
				$pesquisadores = explode(";",$requisicao["pesquisadores"]);

				# Monta array com os pesquisadores da rede já instânciados 
				$pesquisadoresDaRede = [];
				for ($i = 0; $i < count($pesquisadores); $i++){
					if($pesquisadores[$i] == "") {
						unset($pesquisadores[$i]);
						continue; 
					}
					$pesquisadoresDaRede[] = new Pesquisador("..\\arquivos\\xml\\pesquisadores\\".$pesquisadores[$i].".xml");
				}

				if(count($pesquisadoresDaRede) < 2)
					$resposta->setResposta("paginaDeErros","Numero de pesquisadores insuficiente para a construção da rede");


				# Consulta redes em comum dos pesquisadores  
				$dao2 = new pesquisadoresDaRedeDAO(); 
				$redesEmComum = [];
				$primeiroEvento = true;
				foreach ($pesquisadoresDaRede as $pesquisador) {
					if(!$primeiroEvento){
						$redesEmComum = array_intersect($redesEmComum, $dao2->getRedesDoPesquisador($pesquisador));
					}else{
						$redesEmComum = $dao2->getRedesDoPesquisador($pesquisador);
						$primeiroEvento = false; 
					}
				}
				
				// Verification the metric e similarity of the  networks in common 
				// Verifica se a rede em comum tem o mesmo número de pesquisadores 
				$dao = new RedesDAO();
				$idRede = null; 
				if(count($redesEmComum) != 0){
					foreach ($redesEmComum as $redeEmComum) {
						$redeConsultada = $dao->getRede($redeEmComum);
						$eq = $redeConsultada["numero_pesquisadores"] == count($pesquisadoresDaRede) 
							&& $redeConsultada['min_similarity'] ==  $requisicao['min_similarity'] 
							&& $redeConsultada['metric'] ==  $requisicao['metric'];
						if($eq){
							$idRede = $redeConsultada['id_rede'];
							break;
						}
					}
				}

				if($idRede != null){
					$resposta->setResposta("visualizador");
					$resposta->setRede($idRede);
				}else{
					
					# Monta a rede, pois neste bloco assumimos que a mesma não existe 
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
					$resposta->setResposta("index", "");
				}

				$dao2->fechaConexao();
				$dao->fechaConexao();
			}catch(Exception $e){
				$resposta->setResposta("paginaDeErros", $m." ". $e->getMessage());
			}
		}
	}

?>