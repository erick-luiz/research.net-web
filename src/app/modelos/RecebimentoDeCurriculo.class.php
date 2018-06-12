<?php

		include_once "classes/Pesquisador.php";
		include_once "persistencia/PesquisadoresDAO.class.php";

	class RecebimentoDeCurriculo{
	
		function __construct(){}

		function servico($curriculosXML, $resposta){

			try{	
				$mensagemDeErro    = "";
				$numeroDeErros     = 0;
				$dao               = new PesquisadoresDAO();

				for ($i=0; $i < count($curriculosXML["name"]); $i++) { 
					
					if($curriculosXML['error'][$i]){
						$numeroDeErros++;
						$mensagemDeErro .= "Ocorreu o seguinte erro ao tentar cadastrar o curriculo ".$curriculosXML['name'][$i]. " : "
						. $this->getErro($curriculosXML['error'][$i]."");
						continue;
					}
					try{
						$pesquisador = new Pesquisador($curriculosXML['tmp_name'][$i]);	
					}catch(Exception $e){
						$numeroDeErros++;
						$mensagemDeErro .= "Erro ao acessar dados do curriculo:".$curriculosXML['name'][$i];
						continue;
					}

					$existencia = $dao->verificaExistencia($pesquisador);
					if(is_array($existencia)){
						if((int)$existencia[3] < (int)$pesquisador->getDataAtualizacao()){
							if(!$dao->atualizaPesquisador($pesquisador)){
								$numeroDeErros++;
								$mensagemDeErro .= "Erro ao atualizar: ".$pesquisador->getNome(). "";
								continue;
							}
						}else{
							$numeroDeErros++;
							$mensagemDeErro .= "O pesquisador  ".$pesquisador->getNome(). "  já esta cadastrado no sistema";
							continue;
						}
					}else{
						if(!$dao->cadastraPesquisador($pesquisador)){
							$numeroDeErros++;
							$mensagemDeErro .= "Erro ao cadastrar: ".$pesquisador->getNome(). "";
							continue;
						}
					}
						
					$this->moveXMLpara("..\\arquivos\\xml\\pesquisadores\\",$pesquisador->getIdLattes().".xml",$curriculosXML['tmp_name'][$i]);
					
				}
				if($numeroDeErros > 0){
					$resposta->setResposta("paginaDeErros",$mensagemDeErro);
				}else{
					$resposta->setResposta("index","");
				}
			}catch(Exception $e){ 
				$resposta->setResposta("paginaDeErros", $e->getMessage()); 
			}finally{
				$dao->fechaConexao();
			}
		}
		function moveXMLpara($destino, $novoNome, $nomeTemporario){
			# Define o caminho e o nome do arquivo
			$uploadfile = $destino . basename($novoNome);
			# Move o arquivo do local temporario para o local definido 
			# caso não consiga sinaliza o erro de leitura do arquivo 
			if (move_uploaded_file($nomeTemporario, $uploadfile)){
				$caminho = $destino;
			}else {
				throw new Exception("Erro ao mover o arquivo");
			}
		}
		function getErro($codigoDeErro){

			// Para mais informações acesse: 
			// http://php.net/manual/pt_BR/features.file-upload.errors.php
			
			switch ($codigoDeErro) {
				case 1:
					return "O arquivo exede o límite de tamanho"; # definido no PHP 
				case 2:
					return "O arquivo exede o límite de tamanho"; # definido no HTML
				case 3:
					return "O arquivo não foi carregado completamente";
				case 4:
					return "O arquivo não pode ser recebido";
				case 6:
					return "O arquivo não encontrou uma pasta temporaria para processamento";
				case 7:
					return "Falha ao escrever o arquivo";
				case 8: 
					return "Upload interrompido";
				default:
					return "Erro indefinido";
			}
		}
	}
?>