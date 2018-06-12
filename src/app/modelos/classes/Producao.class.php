<?php
	
	include "Autor.php";
	include "AreaDoConhecimento.php";
	include "VerificadorDeSimilaridade.class.php";
	include "comparadorDeTrabalhos.interface.php";
	
	
	abstract class Producao{
		function __construct(){
			$this->numeroDePalavrasChave = 0; 
			$this->numeroDeAutores       = 0;
			$this->duplicataId           = null;
			$this->levenshteinMinimo     = 30;
		}
		
		function getIdDuplicata(){ return $this->duplicataId;}
		function getAutores(){     return $this->listaDeAutores; }
		function getTitulo(){      return $this->titulo; }
		function getNumeroDeAutores(){       return $this->numeroDeAutores; }
		function getNumeroDePalavrasChave(){ return $this->numeroDePalavrasChave; }

		function setDuplicata($id){$this->duplicataId = $id;}

		// Retorna porcentagem de equivalencia de igualdade indo de 0 a 1
		// Sendo  1 para igual e 0 para diferente 
		function verificaEquivalencia($producao){
			if($this->doi != null && $producao->getDoi() != null){
				if($this->doi == $producao->getDoi()) return 1; 
				else return 0;
			}
			return $this->comparaCaracteristicas($producao);
		}

		function comparaAutores($producao, $verificador){
			if(count($this->getAutores()) < count($producao->getAutores())){
				$menosAutores = $this->getAutores();
				$maisAutores  = $producao->getAutores();
			}else{
				$maisAutores = $this->getAutores();
				$menosAutores  = $producao->getAutores();
			}
			if(count($menosAutores)== 0) return false;
			foreach ($menosAutores as $autor){
				foreach ($maisAutores as $autor2){
					if(!$autor->compara($autor2)) return false;
				}
			}
			
			return true; 
		}

		function setListaDeAutores($autores){
			$this->listaDeAutores = []; 
			
			foreach ($autores as $autor) {
				if(array_key_exists("@attributes", $autor)){
					$autorAux = $autor["@attributes"];
					// Verificação das chaves 
					$nomeCompleto = array_key_exists("NOME-COMPLETO-DO-AUTOR", $autorAux)?$autorAux["NOME-COMPLETO-DO-AUTOR"]:"";
					$id = array_key_exists("NRO-ID-CNPQ", $autorAux)?$autorAux["NRO-ID-CNPQ"]:NULL;
					$ordem = array_key_exists("ORDEM-DE-AUTORIA", $autorAux)?$autorAux["ORDEM-DE-AUTORIA"]:NULL;
					$nomeCitacao = array_key_exists("NOME-PARA-CITACAO", $autorAux)?$autorAux["NOME-PARA-CITACAO"]:NULL;
 
					$this->listaDeAutores[] = new Autor(
						$nomeCompleto,
						$id,
						$ordem,
						$nomeCitacao
					);
				}	
			}

			$this->numeroDeAutores = count($this->listaDeAutores);
		}
		function setPalavrasChave($palavrasChave){

			$this->palavrasChave = []; 

			for($i = 1; $i <= 6; $i++){
				if($palavrasChave["PALAVRA-CHAVE-".$i] == null) break; 
				$this->palavrasChave[] = $palavrasChave["PALAVRA-CHAVE-".$i];
			}


			$this->numeroDePalavrasChave = count($this->palavrasChave);
		}
		function setAreasDoConhecimento($areasDoConhecimento){

			$this->listaDeAreasDoConhecimento = [];
			foreach ($areasDoConhecimento as $area) {
				$this->listaDeAreasDoConhecimento[] = new AreaDoConhecimento(
					$area["@attributes"]["NOME-GRANDE-AREA-DO-CONHECIMENTO"],
					$area["@attributes"]["NOME-DA-AREA-DO-CONHECIMENTO"],
					$area["@attributes"]["NOME-DA-SUB-AREA-DO-CONHECIMENTO"],
					$area["@attributes"]["NOME-DA-ESPECIALIDADE"]
				);
			}
			$this->numeroDeAreasDoConhecimento = count($this->listaDeAreasDoConhecimento);
		}
		abstract public function getTituloEstruturado();
	}
?>