<?php
	
	include_once "FabricaDeConexao.class.php";

	class PesquisadoresDAO{

		private $conexaoBanco;

		function __construct(){
			$conexao = new FabricaDeConexao();
			$this->conexaoBanco = $conexao->getConexao();
		}
		/**
		* Método para consultar o banco de dados 
		* Retorna um array vazio caso não tenham pesquisadores cadastrados 
		**/
		function listaPesquisadores(){
			
		    try {
		    	$sql = "Select * from pesquisadores";
		    	$this->conexaoBanco->prepare($sql);
		        return $this->conexaoBanco->query($sql);

		    } catch(PDOException $e){
		        return $e->getMessage();
		    } 
		}
		function getIdPesquisador($pesquisador){
			try{
				$sql = 'SELECT id_pesquisador FROM pesquisadores WHERE idLattes=\''.$pesquisador->getIdLattes().'\'';
				$consulta = $this->conexaoBanco->query($sql);
				$consulta = $consulta->fetch(); # Retorna um elemento da consulta (Array)
				return $consulta['id_pesquisador']; 
			}catch(Exception $e){
				throw new Exception("Não foi possivel localizar o pesquisador em nossos registros", 1);
			}
		}
		function verificaExistencia($pesquisador){

				$sql = 'Select * from pesquisadores WHERE nome=\''.$pesquisador->getNome().'\' AND	idLattes =\''.$pesquisador->getIdLattes().'\'';

				$consulta = $this->conexaoBanco->query($sql);

				if($consulta->rowCount() > 0){
					return $consulta->fetch(); 
				}
				else return false; 
		}
		function atualizaPesquisador($pesquisador){
			try{

			$sql = "UPDATE pesquisadores 
				SET data = :data
				WHERE idLattes = :id";
			$update = $this->conexaoBanco->prepare($sql);
			$update->execute(array(
					'data' => $pesquisador->getDataAtualizacao(), 
					'id' => $pesquisador->getIdLattes()
				));
				return true;
			}catch(Exception $e){
				return false;
			}
		}

		function cadastraPesquisador($pesquisador){

			try{
				$sql = "INSERT INTO pesquisadores(nome,data,IdLattes) VALUES (:nome,:data,:idLattes)"; 
	 			$insercao = $this->conexaoBanco->prepare($sql);
				$insercao->execute(array(
	  				':nome' => $pesquisador->getNome(),
					':data' => $pesquisador->getDataAtualizacao(),
					':idLattes' => $pesquisador->getIdLattes() 
				));	
				return true;
			}catch(Exception $e){
				return false;
			}
		}
		function fechaConexao(){
			$this->conexaoBanco = null;
		}
	}	
?>