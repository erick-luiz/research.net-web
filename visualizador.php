<?php
	if($_GET["rede"]){
		$id = $_GET["rede"]; 
		echo ("<div id='idRede' style='display:none;'>".$id."</div>");
	}else{
		header("location: paginaDeErros.php?mensagem=Rede a ser visualizada não foi definida!");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Visualizador de Redes</title>
<!-- 	<link rel="stylesheet" href="css/estilo.css"> -->
    <link rel="stylesheet" href="css/modal.css" />
	<link rel="stylesheet" href="css/visualizador.css">
	<?php include "importacoes/CSS_imports.php" ?>

</head>
<body onload="carregaRede()">
	<?php include "visoes/menu.html";?>
	<div class="container">
		<div id="modal">
        	<div class="corpo-do-modal">
        		<button onclick="fechaModal();">Fechar Visualização</button>
            <div id="modal-dados"></div>
            </div>
        </div>

    <div id="anos-de-producao"></div>
    

    <div class="jumbotron" style="margin-top: 1em;">
      <h1 id="titulo-da-rede"></h1> 
    </div> 

    <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="viewer-tab" data-toggle="tab" href="#viewer" role="tab" aria-controls="viewer" aria-selected="true">Visualizador</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="productions-tab" data-toggle="tab" href="#productions" role="tab" aria-controls="productions" aria-selected="false">Produções</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="area-tab" data-toggle="tab" href="#area" role="tab" aria-controls="area" aria-selected="false">b</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pergunta-tab" data-toggle="tab" href="#pergunta" role="tab" aria-controls="pergunta" aria-selected="false">g</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="form-cad-tab" data-toggle="tab" href="#form-cad" role="tab" aria-controls="form-cad" aria-selected="false">o</a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="viewer" role="tabpanel" aria-labelledby="home-tab">
            <?php include_once "views/viewer/graph.view.php";?>
          </div>

          <div class="tab-pane fade" id="productions" role="tabpanel" aria-labelledby="formulario-tab">
              <?php include_once "views/viewer/productions.view.php";?>
          </div>
          <div class="tab-pane fade" id="area" role="tabpanel" aria-labelledby="area-tab">
              
          </div>
          <div class="tab-pane fade" id="pergunta" role="tabpanel" aria-labelledby="pergunta-tab">
            
          </div>
          <div class="tab-pane fade" id="form-cad" role="tabpanel" aria-labelledby="form-cad-tab">
            
          </div>
        </div>  

    
  </div>
  <!-- Templates -->
  <option id="option-layout" style="display: none;"></option>
  <?php include "importacoes/visualizador.importacoes.php"; ?>

  <?php include_once "visoes/footer.html" ;?>

	<script> $('#area-de-apresentacao').springy({ graph: grafo }); </script>
	<script type="text/javascript" src="scripts/FuncoesDoModal.js"></script>
  
  <?php  include "importacoes/JS_imports.php"; ?>
  <script type="text/javascript" src="scripts/requests.js"></script>
  <script type="text/javascript">
    getProductions(window.idFirstResearched);
  </script>
</body>
</html>