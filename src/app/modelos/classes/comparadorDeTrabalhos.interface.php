<?php
	interface comparadorDeTrabalhos{
		function comparaTitulos($producao, $verificador);
		function comparaLocalDePublicacao($producao, $verificador);
		function comparaAutores($producao, $verificador); 
		function comparaPropriedadesExclusivas($producao, $verificador);
	}
?>