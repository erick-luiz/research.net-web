<?php
  $pesquisadores = file_get_contents("http://localhost/research.net/src/app/controles/controladorDeRequisicao.php?requisicao=listaPesquisadores");
  $pesquisadores = json_decode($pesquisadores, true); 
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />
      <!-- <link href="css/estilo.css" rel="stylesheet"> --><!-- Autor: Erick Lopes --> 
      <link rel="stylesheet" type="text/css" href="css/modal.css" />
      <?php include "importacoes/CSS_imports.php" ?>
   </head>
   <body>
    <?php include "visoes/menu.html"; ?> <!-- Importação do MENU -->
    
      s<div class="container">
      <div id="modal">
          <div class="corpo-do-modal">
            <button onclick="fechaModal();">Fechar Visualização</button>
            <div id="pesquisadores-da-rede"></div>

          </div>
      </div>


      <div class="titulo-geral">
        <h2>Pesquisadores adicionados na rede em construção </h2>
      </div>
      <section class="coluna-90">
        
        <form action="src/app/controles/ControladorDeRequisicao.php" id="form-criador-rede">
          
          <div class="form-group">
            <label for="titulo">Título da Rede</label>
            <input name="titulo" placeholder="Título" type="text" class="form-control" required="required" id="titulo"/>
          </div>

          <div class="form-group">
            <label for="metric">Métrica</label>
            <select name="metric" class="form-control" id="metric">
              <option value="levenshtein" selected="">Levenshtein</option>
              <option value="jaccard">Jaccard</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="min_similarity">Similaridade Mínima</label>
            <input type="number" name="min_similarity" class="form-control" id="min_similarity" placeholder="0.01" step="0.01" min="0.01" max="1">
          </div>
        <button value="Enviar" type="submit" class="btn btn-default">Enviar</button>
        </form>

        <br>
        <button type="button" class="btn-primary" onclick="abreModal();">Pesquisadores Selecionados</button>
        <br>

        <br>
        <table class="table table-striped">
          <tr><th>Nome</th><th>Id</th><th>Data da Ultima Atualizacao</th><th>Inserir na rede</th></tr>
          <?php
            foreach ($pesquisadores as $pesquisador) {
              echo ("<tr><td id=pesquisador".$pesquisador['idLattes'].">".$pesquisador['nome']."</td><td>".$pesquisador['idLattes']."</td><td>".$pesquisador['data']."</td>");
              echo ("<td><input type='checkbox' name='pesquisador' onclick='addPesquisadorLista(this);' value='".$pesquisador['idLattes']."'></td></tr>");
            }
          ?>
        </table>
        <div>
      </section>


    </div>  
      <?php include "visoes/footer.html" ?>
      <script type="text/javascript" src="scripts/estruturaDados.js"></script>
      <script type="text/javascript" src="scripts/FuncoesDoModal.js"></script>
      <?php include "importacoes/JS_imports.php" ?>
  </body>
</html>