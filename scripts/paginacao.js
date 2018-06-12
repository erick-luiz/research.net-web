//*** Autor: Érick Luiz Fonsêca Lopes 
//    Data: 07/10/2017
//    contato: si.erickluiz@gmail.com

verificaPassadores();

// Funções do sistema de paginação 
function ativarPagina(obj){
  // Encontra o botão que contenha na classe a palavra active
  var paginaAtivada = document.querySelector('button[class*=active]');
  // Remove a classe active do elemento   
  var novaClasse = paginaAtivada.className.replace("active","");
  // Atribui a classe ao elemento sem a ativação 
  paginaAtivada.className = novaClasse; 
  // Ativa o elemento clicado dando a ele a classe active 
  obj.className = obj.className + " active";
  // mostra o conteúdo referente a pagina ativada
  mostraPagina(obj.value); 
  verificaPassadores();
}
// trata das div's de conteudo, desativa a que estava visivel e ativa a nova 
function mostraPagina(idAtivar){
  // Muda a div visivel para invisivel 
  var paginaVisivel = document.querySelector('div[class*=visivel]');
  var novaClasse = paginaVisivel.className.replace("visivel","inviisivel");
  paginaVisivel.className = novaClasse;
  // Seleciona a div correspondente a página clicada e torna ela visivel 
  var novaPgVisivel = document.querySelector('#pagina'+idAtivar);
  novaClasse = novaPgVisivel.className.replace("inviisivel","visivel");
  novaPgVisivel.className = novaClasse;
}
// Verifica se o primeiro elemento e o ultimo elemento estão visiveis 
// Se estiverem ele desativa os passadores (.anteriores e .proximos)
function verificaPassadores(){
  // Pega o primeiro botão da sequencia de botões 
  var primeiroBotao = document.querySelector('#listaDePagina button:first-child + button');
  // verifica se ele é o primeiro botão visivel, se sim é desabilitado
  if(primeiroBotao.className.indexOf("pV") != -1){
    // Modificação dos atributos dos botões passadores 
    document.querySelector('#anteriores').className = "desabilitado";
    document.querySelector('#anteriores').disabled = "desabled";
  }else{
    document.querySelector('#anteriores').className = "";
    document.querySelector('#anteriores').disabled = "";
  }
  // Pega o ultimo botão de página 
  var ultimoBotao = document.querySelector('#listaDePagina button:nth-last-child(2)');
  // verifica se ele é o ultimo visivel, se sim desabilita o passador 
  if(ultimoBotao.className.indexOf("uV") != -1){
    document.querySelector('#proximos').className = "desabilitado";
    document.querySelector('#proximos').disabled = "desabled";
  }else{
    document.querySelector('#proximos').className = "";
    document.querySelector('#proximos').disabled = "";
  }
}
// Funcionalidade do passador próximo 
function proximo(obj){
  if(obj.disabled==""){
    // Pega o ultimo botão visivel e o seguinte a ele 
    var posultimoVisivel = document.querySelector('.uV + button');
    var ultimoVisivel    = document.querySelector('.uV');
    
    // Verifica se o próximo botão esta ativado, se sim mantém    
    if(posultimoVisivel.className.indexOf("active") != -1){
      posultimoVisivel.className = "uV active"; 
    }else{
      posultimoVisivel.className = "uV";
    }
    // Verifica se ultimo visivel está ativado, se sim mantem ativado 
    if(ultimoVisivel.className.indexOf("active") != -1){
      ultimoVisivel.className = "visivel active";
    }else{
      ultimoVisivel.className = "visivel";
    }
      
    // Recebe o primeiro e o segundo botão visivel 
    var segundoVisivel = document.querySelector('.pV + button');
    var primeiroVisivel = document.querySelector('.pV');

    // Verifica se o segundo botão esta ativado, se sim mantém a ativação 
    if(segundoVisivel.className.indexOf("active") != -1){
        segundoVisivel.className = "pV active";
    }else{
      segundoVisivel.className = "pV";
    }
    // Verifica se o primeiro botão esta ativado, se sim mantém a ativação 
    if(primeiroVisivel.className.indexOf("active") != -1){
      primeiroVisivel.className = "inviisivel active";
    }else{
      primeiroVisivel.className = "inviisivel";
    }
    // Após atualizar os botões devemos verificar se os passadores estão corretamente ativados 
    verificaPassadores();     
  }
}
// Implementação da funcionalidade do botão anterior 
function anterior(obj){
  // verifica se ele esta abilitado para uso  
  if(obj.disabled==""){
    // Pega ultimo botão visivel 
    var ultimoVisivel = document.querySelector('.uV');
    // pega o valor do ultimo botão visivel 
    var valor = parseInt(ultimoVisivel.value);
    // pega o penultimo botão visivel om o valor do anterior 
    var penultimoVisivel = document.querySelector('#listaDePagina button:nth-child('+valor+')');
        
        // Verifica e mantém o botão ativado 
        if(ultimoVisivel.className.indexOf("active") != -1){
          ultimoVisivel.className = "inviisivel active";
        }else{
          ultimoVisivel.className = "inviisivel";
        }
        // Verifica e mantém o botão ativado
        if(penultimoVisivel.className.indexOf("active")!= -1){
          penultimoVisivel.className = "uV active";
        }else{
          penultimoVisivel.className = "uV";
        }

    // Trata o extremo da esquerda dos botões (menores valores)
    var primeiroVisivel = document.querySelector('.primeiroVisivel');
    var valor = parseInt(primeiroVisivel.value);
    var segundoVisivel = document.querySelector('#listaDePagina button:nth-child('+valor+')')

    if(primeiroVisivel.className.indexOf("active") != -1){
      primeiroVisivel.className = "visivel active";
    }else{
      primeiroVisivel.className = "visivel";
    }
    if(segundoVisivel.className.indexOf("active") != -1){
      segundoVisivel.className = "primeiroVisivel active";
    }else{
      segundoVisivel.className = "primeiroVisivel";
    }
    verificaPassadores();
  } 
}
function exibeRedes(){

  // Recebe as redes lisdas encapsulando a tag de id dadosRedes 
  var dadosRedes    = $("#dadosRedes").html();
  // Transforma os dados lidos em Formato de objetos 
  var redes = JSON.parse(dadosRedes);
  var numeroDeRedes = redes.length;
  var div_saida = "";
  var contador  = 0; 
  var inicio = true;
  var contadorDePaginas = 1;

  // Percorre as redes 
  redes.forEach(function(rede, indice){
    if(contador % 3 == 0){
      if(inicio){
        div_saida = div_saida + "<div class='linha visivel' id=pagina"+contadorDePaginas.toString()+">";
        criaBotaoDePaginacao('pV-active', contadorDePaginas);
        inicio = false;
        contadorDePaginas++;
      }else{
        div_saida = div_saida + "</div><div class='linha inviisivel' id=pagina"+contadorDePaginas.toString()+">";
        criaBotaoDePaginacao("visivel",contadorDePaginas);
        contadorDePaginas++;
      }
    }
    div_saida = div_saida + "<div class=coluna-3><p><b>Titulo: </b>"+rede["titulo"]+
    "</p><p><b>Instituição: </b>"+rede["instituicao"]+
    "</p><p><b>Autor:</b>"+rede["id_autor"]+"</p></div>";
    contador++;
  })
  div_saida = div_saida + "</div>";
  // Insere os dados das redes na tela 
  document.querySelector("#linhaDeRedes").insertAdjacentHTML("afterBegin",div_saida);
}
function criaBotaoDePaginacao(classe, valor){
  var botao = "<button onclick=ativarPagina(this) class="+classe.toString()+" value="+valor+">"+valor+"</button>";
  document.querySelector("#proximos").insertAdjacentHTML("beforeBegin",botao);
}

exibeRedes();