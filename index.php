<?php 
  $redes = file_get_contents("http://localhost/research.net/src/app/controles/controladorDeRequisicao.php?requisicao=ListaRedes");
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8" />
    <?php include "importacoes/CSS_imports.php" ?>    
  </head>
  <body>


      <?php include "visoes/menu.html" ?>
    <div class="container bg-light">

      <div id="dados-redes" style="display: none"><?php print_r($redes);?></div>

      <div class="titulo-geral"> <h2>Redes cadastradas </h2> </div>
    
      <?php include "visoes/Rede.html" ?>
    </div>
        <?php include "visoes/footer.html" ?>
    <?php include "importacoes/JS_imports.php" ?>
  </body>
</html>