<?php
	class FabricaDeConexao{
		function __construct(){
				$this->nome    = "research.net"; 
				$this->host    = "localhost";
				$this->usuario = "root"; 
				$this->senha   = "";
		}
		function getConexao(){
			try{
				$pdo = new PDO(
					"mysql:host=".$this->host.";dbname=".$this->nome, 
					$this->usuario, 
					$this->senha
				); 
		        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   				return $pdo;	
   			}catch(PDOException $e) {
        		$this->erro = $e->getMessage();
    		}
		}
		function fechaConexao($pdo){
			$pdo->close();
		}
	}
?>	