<?php
	
	include_once "FabricaDeConexao.class.php";
	include_once "PesquisadoresDAO.class.php";


	class PesquisadoresDaRedeDAO{

		function __construct(){
			$conexao = new FabricaDeConexao();
			$this->conexaoBanco = $conexao->getConexao();
		}
		function getRedesDoPesquisador($pesquisador){
			
			$dao = new PesquisadoresDAO(); 
			$id = $dao->getIdPesquisador($pesquisador); 
			$dao->fechaConexao();
			$sql = "SELECT id_rede FROM pesquisadoresdarede WHERE id_pesquisador =".$id;
			$this->conexaoBanco->prepare($sql);
			$consulta = $this->conexaoBanco->query($sql);
			$consulta = $consulta->fetchAll();
			$retorno = []; 
			# A PDO retorna um array com duas associação uma é o indice e a outra o nome, 
			# cada resposta é vista como um array, 
			# por isto este foreach ajusta o array de retorno 
			foreach ($consulta as $rede) { $retorno[] = $rede[0]; }
			return array_unique($retorno);
		}
		function cadastraPesquisadoresDaRede($pesquisadores, $idRede){
			$dao = new PesquisadoresDAO();
			foreach ($pesquisadores as $pesquisador) {
				$idPesquisador = (String)$dao->getIdPesquisador($pesquisador);

				$sql = "INSERT INTO pesquisadoresdarede (id_rede, id_pesquisador) VALUES (:id_rede,:id_pesquisador)";
				$insercao = $this->conexaoBanco->prepare($sql);
				print_r($idRede);
				$insercao->execute(array(
	  				':id_rede' => $idRede,
					':id_pesquisador' => $idPesquisador
				));	
			}
		}
		function cadastraPesquisador($pesquisador){

			try{
				$sql = "INSERT INTO pesquisadores(nome,data,IdLattes) VALUES (:nome,:data,:idLattes)"; 
	 			
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