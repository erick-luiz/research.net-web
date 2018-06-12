<?php
	include_once "persistencia/PesquisadoresDAO.class.php";
	

	class ListaPesquisadores{
	
		function servico($requisicao, $resposta){
			$pesquisadores = (new PesquisadoresDAO())->listaPesquisadores();
	
			$dados = [];
			foreach ($pesquisadores as $pesquisador) {
				$dados[] = Array(
					'nome' => $pesquisador["nome"],
					'idLattes' => $pesquisador["idLattes"],
					'data' =>$pesquisador["Data"]
				);
			}
			$resposta->setMetodo("JSON");
			$resposta->setDados(json_encode($dados));
		}
	}
?>