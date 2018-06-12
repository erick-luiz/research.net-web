<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />
      <!-- <link href="css/estilo.css" rel="stylesheet"> --><!-- Autor: Erick Lopes --> 
      <?php include "importacoes/CSS_imports.php" ?>
   </head>
   <body>

      <?php include "visoes/menu.html"; ?> <!-- Importação do MENU -->
      <div class="container"> 
       <div class="titulo-geral">
        <h2>Cadastrar Pesquisador</h2>
      </div>
      <section>
        <div class="coluna-90">
          <p>Cadastre os XML's dos currículos Lattes no campo abaixo: </p>
          <form onsubmit="confereTamanhoCurriculos(this);" id="cadastro-curriculo" enctype="multipart/form-data" role="form" method="POST" action="src/app/controles/ControladorDeRequisicao.php" data-toggle="validator">  
              
            
            <input type="hidden" value="RecebimentoDeCurriculo" name="requisicao" />
            <div class="coluna-2" style="min-height: 250px;">
              <input type="hidden" name="MAX_FILE_SIZE" id="tamanho-curriculo" value="3000000000" />
              <input type="file" id="curriculoXML" name="curriculoXML[]" value="" required multiple accept=".xml" />
              <button type="submit" class="btn btn-default" value="enviar dados">Cadastrar currículos</button>
            </div>
          </form>              
        </div>
      </section>
    </div>
    <?php include "visoes/footer.html" ?>
      <script src="scripts/jquery.min.js" type="text/javascript"></script>
      <script src="scripts/script.js" type="text/javascript"></script>
      <?php include "importacoes/JS_imports.php" ?>
  </body>
</html>