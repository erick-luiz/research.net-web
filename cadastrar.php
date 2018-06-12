<?php
   include "funcoesParaUsoGeral.php";
   $usuarioLogado = verificaSeUsuarioEstaLogado();
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
      <meta charset="utf-8" />

      <link href="css/estilo.css" rel="stylesheet"><!-- Autor: Erick Lopes --> 
   </head>
   <body>
   <!-- Modal de Login na Aplicação -->
      <div id="id01" class="modal">
  
  <form class="modal-content animate" action="/action_page.php">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>
        
      <button type="submit">Login</button>
      <input type="checkbox" checked="checked"> Remember me
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>
  </form>
</div>
      <!-- Menu Superior -->
      <div class="topnav" id="myTopnav">
         
            <a class="navbar-brand" id="link-logo" href="#">
            <table>
               <tr>
                  <td><img src="imagens/logo.png" alt="Logotipo da aplicação research.NET" class="logo"></td>
                  <td>Research.NET</td>
               </tr>
            </table>
            </a>
         <a href="redes.php" class="active">Redes</a>
         <a href="pesquisadores.php">Pesquisadores</a>
         <a href="#" onclick="document.getElementById('id01').style.display='block'">login</a>
         <a href="cadastrar.php" class="cadastrar">Cadastre-se</a>
         <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
      </div>
      <section>
            
      </section>
      <script src="scripts/script.js" type="text/javascript"></script>
  </body>
</html>