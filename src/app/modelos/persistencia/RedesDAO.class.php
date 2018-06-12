<?php

	include_once "FabricaDeConexao.class.php";

	class RedesDAO{
		function __construct(){
			$conexao = new FabricaDeConexao();
			$this->conexaoBanco = $conexao->getConexao();
		}
		/**
		* Método para consultar o banco de dados 
		* Retorna um array vazio caso não tenham redes cadastrados 
		**/
		function listaRedes(){
			
		    try {
		    	$sql = "Select * from redes";
		    	$this->conexaoBanco->prepare($sql);
		        return $this->conexaoBanco->query($sql);

		    } catch(PDOException $e){
		        return $e->getMessage();
		    } 
		}
		function cadastraRede($rede){

			$titulo    			 = $rede->getTitulo();
			$numeroPesquisadores = $rede->getNumeroDePesquisadores();
			$dataCriacao         = date("Y/m/d");
			$metric 			 = $rede->getMetric();
			$min_similarity 	 = $rede->getMinSimilarity();
			
			try{
				$sql = "INSERT INTO redes (Titulo, numero_pesquisadores, data_criacao, metric, min_similarity) VALUES (:titulo,:numero_pesquisadores,:data_criacao,:metric,:min_similarity)"; 
	 			$insercao = $this->conexaoBanco->prepare($sql);

				$insercao->execute(array(
	  				':titulo'=>$titulo,
	  				':numero_pesquisadores'=>$numeroPesquisadores,
	  				':data_criacao'=>$dataCriacao,
	  				':metric'=>$metric,
	  				':min_similarity'=> $min_similarity

				));			
				return "sucesso";
			}catch(Exception $e){
				return $e->getMessage();
			}
		}
		function getRede($id){
			$sql = "SELECT * FROM redes WHERE id_rede = $id";
		    $this->conexaoBanco->prepare($sql);
		    $consulta = $this->conexaoBanco->query($sql);
		    return $consulta->fetch();
		}
		function idUltimoRegistro(){
			try{
				$sql = "SELECT id_rede FROM redes ORDER BY id_rede DESC LIMIT 1";
		    	$this->conexaoBanco->prepare($sql);
		    	$consulta = $this->conexaoBanco->query($sql);
		    	$consulta = $consulta->fetch(); # Retorna apenas um elemento da consulta como array  
		    	return $consulta['id_rede'];
			}catch(Exception $e){
				throw new Exception("Erro ao reconhecer a rede ", 1);
			}
		}
		function fechaConexao(){
			$this->conexaoBanco = null;
		}
	}

?>