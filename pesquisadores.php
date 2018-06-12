<?php
  $pesquisadores = file_get_contents("http://localhost/research.net/src/app/controles/controladorDeRequisicao.php?requisicao=listaPesquisadores");
  $pesquisadores = json_decode($pesquisadores, true); 
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />
      <!-- <link href="css/estilo.css" rel="stylesheet"> --><!-- Autor: Erick Lopes --> 
      <!-- <link rel="stylesheet" type="text/css" href="css/paginacao.css">-->
      <?php include "importacoes/CSS_imports.php" ?>
   </head>
   <body>
      
      <?php include "visoes/menu.html" ?> <!-- Importação do MENU -->

      <div class="titulo-geral">
        <h2>Pesquisadores cadastrados </h2>
      </div>

      <section class="coluna-90">
      <table>
      <tr><th>Nome</th><th>Id</th><th>Data da Ultima Atualizacao</th></tr>
      <?php
        foreach ($pesquisadores as $pesquisador) {
          echo ("<tr><td>".$pesquisador['nome']."</td><td>".$pesquisador['idLattes']."</td><td>".$pesquisador['data']."</td></tr>");
        }
      ?>
      </table>
      </section>
      <?php include "importacoes/JS_imports.php" ?>
  </body>
</html>