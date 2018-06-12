<?php
	
	include_once "persistencia/RedesDAO.class.php";

	class ListaRedes{
		function servico($requisicao, $resposta){
			$redes = (new RedesDAO())->listaRedes();
			$resposta->setResposta("index"); 
	
			$dados = [];
			foreach ($redes as $rede) {
				$dados[] = Array(
					'titulo' => $rede["Titulo"],
					'caminho' => $rede["numero_pesquisadores"],
					'data' =>$rede["data_criacao"],
					'id' => $rede["id_rede"]
				);
			}
			$resposta->setMetodo("JSON");
			$resposta->setDados(json_encode($dados));
		}
	}
?>