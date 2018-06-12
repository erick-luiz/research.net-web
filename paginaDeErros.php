<?php 

 $erro = isset($_GET['mensagem'])?$_GET['mensagem']:false;
 if(!$erro) header("location:index.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />
      <link href="css/estilo.css" rel="stylesheet"><!-- Autor: Erick Lopes --> 
      <link rel="stylesheet" type="text/css" href="css/paginacao.css">
   </head>
   <body>
      
      <?php include "visoes/menu.html" ?> <!-- Importação do MENU -->


      <section>
            <div class="linha">
            	<div class="coluna-1 erro">
            		<header id="header" class="header-erro">
            			Mensagem de Erro : 	
            		</header><!-- /header -->
            		<p><?php echo ($erro);?></p>
            		<footer>
            			Tende refazer a operação. <a href="index.php">Inicio</a>
            		</footer>
           		</div>
            </div>
      </section>
      <script src="scripts/jquery.min.js" type="text/javascript"></script>
      <script src="scripts/paginacao.js" type="text/javascript"></script>
      <script src="scripts/script.js" type="text/javascript"></script>
  </body>
</html>