<?php
	
	include "Producao.class.php";

	class TrabalhoEmEventos extends Producao implements comparadorDeTrabalhos{
		function __constructed(){} 
		function setDadosBasicos($dadosBasicos){
			$this->natureza = $dadosBasicos["NATUREZA"];
			$this->titulo = $dadosBasicos["TITULO-DO-TRABALHO"];
			$this->ano = $dadosBasicos["ANO-DO-TRABALHO"];
			$this->paisDivulgacao = $dadosBasicos["PAIS-DO-EVENTO"];
			$this->idioma = $dadosBasicos["IDIOMA"];
			$this->meioDivulgacao = $dadosBasicos["MEIO-DE-DIVULGACAO"];
			$this->home_page = $dadosBasicos["HOME-PAGE-DO-TRABALHO"];
			$this->flag_relevancia = $dadosBasicos["FLAG-RELEVANCIA"];
			$this->titulo_em_ingles = $dadosBasicos["TITULO-DO-TRABALHO-INGLES"];
			$this->doi = $dadosBasicos["DOI"];
			# verificar chave caso use este recurso 
			//$this->flag_divulgacao_cientifica =  $dadosBasicos["FLAG-DIVULGACAO-CIENTIFICA"];
		}
		function setDetalhamento($detalhamento){
			$this->classificaoDoEvento = $detalhamento["CLASSIFICACAO-DO-EVENTO"];
			$this->nomeDoEvento = $detalhamento["NOME-DO-EVENTO"];
			$this->cidadeDoEvento = $detalhamento["CIDADE-DO-EVENTO"];
			$this->anoDeRealizacao = $detalhamento["ANO-DE-REALIZACAO"];
			$this->tituloDosAnais = $detalhamento["TITULO-DOS-ANAIS-OU-PROCEEDINGS"];
			$this->volume = $detalhamento["VOLUME"];
			$this->fasciculo = $detalhamento["FASCICULO"];
			$this->serie = $detalhamento["SERIE"];
			$this->paginaInicial = $detalhamento["PAGINA-INICIAL"];
			$this->paginaFinal = $detalhamento["CLASSIFICACAO-DO-EVENTO"];
			$this->isbn = $detalhamento["ISBN"];
			$this->nomeDaEditora = $detalhamento["NOME-DA-EDITORA"];
			$this->cidadeDaEditora = $detalhamento["CIDADE-DA-EDITORA"];			
			# Deve conferir existencia de chave caso se use o nome em inglês S
			//$this->nomeDoEventoIngles = $detalhamento["NOME-DO-EVENTO-INGLES"];	
		}
		//@Override
		public function getTituloEstruturado(){
			$titulo = "";
			$contadorAuxiliar = 0;
			foreach ($this->getAutores() as $autor){
				$separador = ($this->getNumeroDeAutores() - 1 == $contadorAuxiliar)? ".":";";
				$nomesDoAutor = explode(";", $autor->getNomeEmCitacoes());
				$titulo .= $nomesDoAutor[0] . "" . $separador;
				$contadorAuxiliar++;
			}
			$titulo .= $this->getTitulo().".";
			$titulo .= " In: ". $this->getNomeDoEvento().", ".$this->getAnoDeRealizacao().", ".$this->getCidadeDoEvento().".";
			$titulo .= $this->getTituloDosAnais().". ";
			$titulo .= $this->getAno().".";
			$titulo = str_replace("..", ".",$titulo);
			return $titulo . "| ANO = " . $this->ano . "| ANO Evento = " . $this->anoDeRealizacao ;
		} 
		function getDoi(){ return $this->doi; }
		function getAno(){ return $this->ano; }
		function getNomeDoEvento() {return $this->nomeDoEvento;}
		function getAnoDeRealizacao() {return $this->anoDeRealizacao;}
		function getCidadeDoEvento() {return $this->cidadeDoEvento;}
		function getTituloDosAnais() {return $this->tituloDosAnais;}
		
		/**
		* Funcões estabelecidas no acordo de implementar a interface comparadorDeTrabalhos
		* 		todas retornam o índice Leveansten da comparacao 
		*/ 
		
		function comparaCaracteristicas($producao, $metric){
			
			$verificador = VerificadorDeSimilaridade::getVerificador();

			//if($this->comparaAutores($producao)) $levenstein = -5; 
			//else $levenstein = 5;
			
			return($this->comparaTitulos($producao, $verificador, $metric));
			// $levenshteinLocal = $this->comparaLocalDePublicacao($producao, $verificador);
			// $levenshteinPropriedades = $this->comparaPropriedadesExclusivas($producao, 
			// $verificador);

			/*if($levenshteinTitulo > 0.6 && $levenshteinLocal > 0.6 && $levenshteinPropriedades > 0.6){	
				
				return ($levenshteinTitulo + $levenshteinLocal + $levenshteinPropriedades)/3;
			}else{
				return 0;
			}*/
		}
		

		// Compara a similaridade entre os titulos da produção 
		function comparaTitulos($producao, $verificador){
			return $verificador->equivalenciaDeStrings( $this->getTitulo(), $producao->getTitulo(), $metric);
		}

		// Compara similaridade entre Local de Publicação
		function comparaLocalDePublicacao($producao, $verificador){
			return $verificador->equivalenciaDeStrings(
				$this->getCidadeDoEvento(), 
				$producao->getCidadeDoEvento());
		}
		// Comparação de demais propriedades 
		function comparaPropriedadesExclusivas($producao, $verificador){
			$levenstein = $verificador->equivalenciaDeStrings($this->getNomeDoEvento(), $producao->getNomeDoEvento());
			$levenstein += $verificador->equivalenciaDeStrings($this->getCidadeDoEvento(), $producao->getCidadeDoEvento());
			$levenstein += $verificador->equivalenciaDeStrings($this->getTituloDosAnais(), $producao->getTituloDosAnais());
			return $levenstein/3;
		}
	}
?>	