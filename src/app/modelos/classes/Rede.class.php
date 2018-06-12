<?php

	include_once "Grafo.class.php";
	include_once "Calculadora.class.php";

	class Rede{
		private $pesquisadores = [], $duplicatas = [];
		 
		function __construct($titulo = "Não Definido", $pesquisadorA, $pesquisadorB, $metric, $minSimilarity){
			$this->titulo = $titulo;
			$this->porcentagemMinima = floatval($minSimilarity);
			$this->pesquisadores[] = $pesquisadorA;
			$this->pesquisadores[] = $pesquisadorB;
			$this->metric          = $metric;
			$this->minSimilarity   = $minSimilarity;
			$this->numeroDeProducoesPorAno = [];
			$this->grafo = new Grafo($titulo);
			$this->totalDeProducoes = $pesquisadorA->getNumeroDeProducoes() + $pesquisadorB->getNumeroDeProducoes();
			$this->grafo->setNumeroDeProducoesUnicas(100);
			$this->identificaDuplicatas($pesquisadorA, $pesquisadorB);
			$this->grafo->addNodo($pesquisadorA);
			$this->grafo->addNodo($pesquisadorB);
		}
		/*
		* Retorna número total de produções unicas da rede, ou seja, 
		* Produções que não fazem parte de duplicatas identificadas 
		*/
		function getMetric(){
			return $this->metric;
		}
		function getMinSimilarity(){
			return $this->minSimilarity;
		}
		function getNumeroDeProducoesUnicas(){
			$somatorio = 0;
			foreach ($this->duplicatas as $duplicata){
				$somatorio += ($duplicata->getNumeroDeAutores()-1);
			}
			return $this->totalDeProducoes - $somatorio;
		}
		/* Retorna número de pesquisadores da rede */
		function getNumeroDePesquisadores(){ return count($this->pesquisadores); }
		/*
		* Retorna todos os anos de produção da rede 
		*/
		function getAnosDeProducaoDaRede(){
			$anos = [];
			foreach ($this->pesquisadores as $pesquisador) { 
				$retorno = $pesquisador->getAnosDeProducao();
				foreach ($retorno as $ano) {
					$anos[] = $ano;
				}
			}
			# Ordena o array de anos para não ser necessario fazer isto no Javascript
			$auxiliar = array_unique($anos);
			asort($auxiliar);
			return ($auxiliar);
		}
		/*
		* Retorna o número de producoes por ano 
		*/
		function getNumeroDeProducoesPorAno(){
			
			$anos = $this->getAnosDeProducaoDaRede();
			foreach($anos as $ano){	
				if(!(array_key_exists($ano, $this->numeroDeProducoesPorAno))){
					$this->numeroDeProducoesPorAno[$ano] = 0;
				}	
				foreach ($this->pesquisadores as $pesquisador) { 
					$this->numeroDeProducoesPorAno[$ano] += $pesquisador->getNumeroProducoesDoAno($ano);
				}
			}
		}
		/*
		* Retorna o número de produções por ano sem duplicações 
		*/
		function getNumeroDeProducoesUnicasPorAno(){
			$producoesUnicasPorAno = [];
			$anos = $this->getAnosDeProducaoDaRede();
			foreach ($anos as $ano) {
				$numProducoesUnicas = 0;
				foreach ($this->pesquisadores as $pesquisador) {
					$numProducoesUnicas += $pesquisador->getNumeroDeProducoesNaoDuplicatas($ano);
				}
				$numDuplicatas = count($this->getDuplicatasDoAno($ano));
				$producoesUnicasPorAno[$ano] = $numProducoesUnicas + $numDuplicatas;
			}
			return $producoesUnicasPorAno;
		}
		/* Retorna uma duplicata por seu identificador */
		function getDuplicata($id){ return $this->duplicatas[$id]; }
		/*
		* Retorna as duplicatas do ano sinalizado 
		*/
		function getDuplicatasDoAno($ano){
			$retorno = [];
			foreach ($this->duplicatas as $duplicata) {
				if($duplicata->getAno() == $ano) $retorno[] = $duplicata;
			}
			return $retorno;
		}
		/* Retorna o titulo da rede */
		function getTitulo(){ return $this->titulo; }

		/*
		* Adiciona um novo pesquisador a rede 
		*/
		function addPesquisador($pesquisadorNovo){ 
			
			foreach ($this->pesquisadores as $pesquisador) {
				$this->identificaDuplicatas($pesquisador,$pesquisadorNovo);
			}
			$this->pesquisadores[] = $pesquisadorNovo;
			$this->grafo->addNodo($pesquisadorNovo);
			$this->totalDeProducoes += $pesquisadorNovo->getNumeroDeProducoes();
		}
		/* Add uma nova duplicata a rede */
		function addDuplicata($duplicata, $identificadorDuplicata){ 
			$this->duplicatas[$identificadorDuplicata] = $duplicata; 
		}

		/*
		* Identifica dupliatas na rede 
		*/

		function identificaDuplicatas($pesquisadorA, $pesquisadorB){
			$calc = CalculadoraDaRede::getCalculadora();
			$producoesDeA = $pesquisadorA->getAnosDeProducao();
			$producoesDeB = $pesquisadorB->getAnosDeProducao();
			$anosDeProducao = array_intersect($producoesDeA,$producoesDeB);
			foreach ($anosDeProducao as $ano){
				foreach ($pesquisadorA->getProducoesDoAno($ano) as $producaoDeA){
					foreach ($pesquisadorB->getProducoesDoAno($ano) as $producaoDeB){
						
						$indice = $calc->Similarity($producaoDeA->getTitulo(),$producaoDeB->getTitulo(), $this->metric);
						if($indice > $this->porcentagemMinima){

							$aresta = $this->grafo->getArestaDe($pesquisadorA, $pesquisadorB, $ano);
							
							// Para que as dulicatas não fiquem com autores a mais do que tem de fato
							if($producaoDeA->getIdDuplicata() == null || $producaoDeB->getIdDuplicata() == null){

								if($producaoDeA->getIdDuplicata() != null){
									$aresta->addDuplicata($producaoDeA->getIdDuplicata(),$ano, $indice,
										$producaoDeA->getTituloEstruturado(),
										$producaoDeB->getTituloEstruturado());
									$producaoDeB->setDuplicata($producaoDeA->getIdDuplicata());
									$this->getDuplicata($producaoDeA->getIdDuplicata())->addAutor();
								}elseif ($producaoDeB->getIdDuplicata() != null){
									$aresta->addDuplicata($producaoDeB->getIdDuplicata(),$ano, $indice,
										$producaoDeA->getTituloEstruturado(),
										$producaoDeB->getTituloEstruturado());
									$producaoDeA->setDuplicata($producaoDeB->getIdDuplicata());
									$this->getDuplicata($producaoDeB->getIdDuplicata())->addAutor();
								}else{
									$duplicata = new Duplicata($ano);
									$aresta->addDuplicata($duplicata->getId(), 
										$ano,  
										$indice,
										$producaoDeA->getTituloEstruturado(),
										$producaoDeB->getTituloEstruturado());
									$producaoDeA->setDuplicata($duplicata->getId());
									$producaoDeB->setDuplicata($duplicata->getId());
									$this->addDuplicata($duplicata, $duplicata->getId());
								}
								break;
							}else{
								if($producaoDeA->getIdDuplicata() == $producaoDeB->getIdDuplicata()){
									if(!$aresta->verificaExistenciaDaDuplicata($producaoDeB->getIdDuplicata(), $ano)){
									$aresta->addDuplicata($producaoDeB->getIdDuplicata(),$ano, $indice,
										$producaoDeA->getTituloEstruturado(),
										$producaoDeB->getTituloEstruturado());
									}
								}
							}	
						}
					}
				}	
			}
		}

		/*
		* Gera o XML de saída da rede 
		*/
		function geraXML($id,$caminho = ""){
			$this->grafo->setAnos($this->getAnosDeProducaoDaRede());
			$this->grafo->setNumeroDeProducoesUnicas($this->getNumeroDeProducoesUnicas());
			$this->grafo->setNumeroDeProducoesUnicasPorAno($this->getNumeroDeProducoesUnicasPorAno());
			try{
				$f = fopen($caminho."".$id.".xml",'w+');
				$grafo = str_replace("&","Eh",$this->grafo->getXML($this->minSimilarity,$this->metric));
				fwrite($f, $grafo);
				fclose($f);
				return "Arquivo Construido";
			}catch(Exception $e){
				return  $e->getMessage();
			}
		}
	}

?>