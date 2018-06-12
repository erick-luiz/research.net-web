var carregamento = false; 
var anosDeProducao = [];
var anoInicial, anoFinal;
var nodosSelecionados = [];
grafo = new Springy.Graph();


function setName(name){
  switch(name){
    case "Alessandro de Lima Bicho": 
      return "Autor 01";
      break;
    case "Andre Prisco Vargas": 
      return "Autor 02";
      break;
    case "Edimar Manica": 
      return "Autor 03";
      break;
    case "Eduardo Nunes Borges": 
      return "Autor 04";
      break;
    case "Graçaliz Pereira Dimuro": 
      return "Autor 05";
      break;
    case "Hélida Salles Santos": 
      return "Autor 06";
      break;
    case "Igor Avila Pereira": 
      return "Autor 07";
      break;
    case "Karina dos Santos Machado": 
      return "Autor 08";
      break;
    case "Leonardo Ramos Emmendorfer": 
      return "Autor 09";
      break;
    case "Maria de Fatima Santos Maia": 
      return "Autor 10";
      break;
    case "Rafael Augusto Penna dos Santos": 
      return "Autor 11";
      break;
    default: 
      return name;
      break;  
  }
}
// Esta função não foi desenvolvida para IE  
function carregaRede(identificador){
  xhttp = new XMLHttpRequest();
  var rede ="rede" + document.querySelector("#idRede").innerText + ".xml";
  

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      leRede(this);
      if(redeXML != null) apresentaGrafo();
    }  
  };
  // Não está legal o carregamento, não deviamos saber onde estão os xml 
  xhttp.open("get", "src/app/arquivos/XML/redes/"+rede, true); 
  xhttp.send();
}
function leRede(xml){ redeXML = xml.responseXML;}
function apresentaDescritor(){

  document.querySelector("#titulo-da-rede").innerText = rede.getTitulo(); 
  document.querySelector("#numero-de-nodos").innerText = rede.getNumeroDeNodos();
  document.querySelector("#similaridade-minima").innerText = rede.getSimilaridadeMin(); 
  document.querySelector("#metrica").innerText = rede.getMetrica();
   
}
function apresentaNumeroDeArestas(numeroDeArestas){
  document.querySelector("#numero-de-arestas").innerText = numeroDeArestas;
}
function apresentaNumeroDeProducoes(){
  var anoInicial = document.querySelector("#ano-inicial").value;
  var anoFinal = document.querySelector("#ano-final").value;

  var numeroDeProducoes = 0;

  for(var i = 0; i < anosDeProducao.length; i++){
    var ano = anosDeProducao[i].getAno();
    if(anoInicial <= ano && ano <= anoFinal){
      numeroDeProducoes += parseInt(anosDeProducao[i].getNumeroDeProducoes());
    }
  }

  rede.ajustaLabelDosNodos(anoInicial, anoFinal);
  document.querySelector("#numero-de-producoes").innerText = numeroDeProducoes;
}

function removerTodosNodos(){ grafo.filterNodes(function(){return false;}); }
function removerTodasArestas() {grafo.filterEdges(function(){return false;});}
function AjustaLayout(){ layout = new Springy.Layout.ForceDirected(grafo,640,480,0,0.5); }

// Refazer a função dividindo para cada atividade a ser executada 
function duploClick(){
  var modo = document.querySelector("#modeViewer").value;

  if(modo == "verDuplicata"){
    nodosSelecionados.push(rede.getNodoComIdLattes(this.id));
    var anoInicial = document.querySelector("#ano-inicial").value;
    var anoFinal   = document.querySelector("#ano-final").value;
    
    if(nodosSelecionados.length > 2){ nodosSelecionados.shift(); }
    if(nodosSelecionados.length == 2) { 
      aresta = rede.getArestaDeNodos(nodosSelecionados[0],nodosSelecionados[1]);
      if(aresta != null){
        var duplicatas = aresta.getDuplicatas();
        
        var texto = "Duplicatas dos Autores: " 
        + nodosSelecionados[0].data.label 
        +" e " + nodosSelecionados[1].data.label 
        +"\n entre " + anoInicial + " e " + anoFinal + "\n\n";

        for(var i = 0; i < duplicatas.length; i++){
          var ano = duplicatas[i].getAno(); 
          if(anoInicial <= ano && ano <= anoFinal){
            texto += duplicatas[i].getTitulo1() + " \n\n";
            texto += duplicatas[i].getTitulo2() + " \n";
            texto += "índice de similaridade: " + duplicatas[i].getIndice() + "\n";
            texto += "---------------------\n";
          }
        }
        var p = document.createElement("p");
        p.innerText = texto;
        var modal = document.querySelector("#modal-dados");
        modal.innerHTML = "";
        modal.appendChild(p);
        // Está função é de outro js (modal.js) desta forma este arquivo deve 
        // ser chamado após o outro  
        abreModal();
      }
    }
  }else if(modo == "verInfo"){
    var p = document.createElement("p");
    nodo = rede.getNodoComIdLattes(this.id, false);
    p.innerText = nodo.getDescricao(document.querySelector("#ano-inicial").value, 
      document.querySelector("#ano-final").value);
    var modal = document.querySelector("#modal-dados");
    modal.innerHTML = "";
    modal.appendChild(p);
    abreModal();
  }
}
function criaNodos(nodos){
  
  var option = $('#option-layout');
  var selected = $("#viewerOfProductions");
  selected.empty();

  for(var i = 0; i < nodos.length; i++){
    
    var id = nodos[i].querySelector("id").textContent
    
    var op = option.clone();
    op.attr({value: id});
    op.html(nodos[i].querySelector("label").textContent);
    op.removeAttr('id');
    op.removeAttr('style');

    selected.append(op);
    if(i == 0) window.idFirstResearched = id;


    var nodo = new Nodo(
      id,
      setName(nodos[i].querySelector("label").textContent),
      nodos[i].querySelector("dataAtualizacao").textContent,
      nodos[i].querySelector("numeroDeProducoes").textContent,
    );
    
    var numeroDeProducoesAno = nodos[i].querySelector("numeroDeProducoesPorAno");
    var anos = numeroDeProducoesAno.querySelectorAll("ano");
    for(var j = 0; j < anos.length; j++){
      nodo.addAno(new Ano(anos[j].getAttribute("value"), anos[j].textContent));
    }

/*    var producoes = nodos[i].querySelectorAll("producao");
    for(var j = 0; j < producoes.length; j++){
      nodo.addProducao(new Producao(
        producoes[j].querySelector("titulo").textContent,
        producoes[j].querySelector("ano").textContent
      ));
    }*/
    

    nodo.setObjSpringy(grafo.newNode({label: nodo.getLabel(),
      id:id,
      ondoubleclick: duploClick
      }));
    rede.addNodo(nodo);
  }
}




function criaArestas(arestas){
  // Percorre arestas do grafo 
  for(var i = 0; i < arestas.length; i++){
    var aresta = new Aresta(
      rede.getNodoComIdLattes(arestas[i].querySelector("autor1").textContent),
      rede.getNodoComIdLattes(arestas[i].querySelector("autor2").textContent)
    );

    // Percorre anos em que a aresta ocorreu 
    var anos = arestas[i].querySelectorAll("ano");
    for (var j = 0; j < anos.length; j++) {
      var ano = anos[j].getAttribute("valor");

      // Percorre as duplicatas da aresta 
      var duplicatas = anos[j].querySelectorAll("duplicata");
      for (var p = 0; p < duplicatas.length; p++) {
        aresta.addDuplicata(new Duplicata( 
          duplicatas[p].querySelector("id").textContent,
          duplicatas[p].querySelector("indice").textContent,
          ano,
          duplicatas[p].querySelector("titulo1").textContent,
          duplicatas[p].querySelector("titulo2").textContent
        ));
      }
    }
    // Cria aresta para ano total 
    aresta.setObjSpringy(grafo.newEdge(
      aresta.getOrigem(),
      aresta.getDestino(),
      {label:aresta.getPeso(anoInicial, anoFinal),directional:false}));
    rede.addAresta(aresta);
  }
  apresentaArestasEntre(anoInicial, anoFinal);
}
function apresentaArestasEntre(anoInicial, anoFinal){
  removerTodasArestas();
  arestas = rede.getArestasEntre(anoInicial, anoFinal);
  
  rede.reinicializaGrauNodos();
 
  for (var i = 0; i < arestas.length; i++) {
    rede.getNodoComIdLattes(arestas[i].getOrigem().data.id, false).setGrau(1, true);
    rede.getNodoComIdLattes(arestas[i].getDestino().data.id, false).setGrau(1, true);
  }


  for(var i = 0; i < arestas.length; i++){
    grafo.addEdge(arestas[i].getObjSpringy());
  }

  apresentaNumeroDeArestas(arestas.length);
  apresentaNumeroDeProducoes();
}


function criaOpcaoDeAno(ano){
  opcao = document.createElement("option");
  opcao.setAttribute("value",ano);
  opcao.innerText = ano; 
  return opcao;
}
// Função definida para identificar todos os anos que a rede produziu 
function identificaAnosDaRede(tagAnos){
  anos = tagAnos.querySelectorAll("ano");
  
  var selecaoAnoInicial = document.querySelector("#ano-inicial");
  var selecaoAnoFinal   = document.querySelector("#ano-final");

  selecaoAnoInicial.addEventListener("change",apresentaRede);
  selecaoAnoFinal.addEventListener("change",apresentaRede);

  for(var i = 0; i < anos.length;i++){


    ano = new Ano(anos[i].getAttribute("valor"), 
      anos[i].querySelector("numero-producoes").textContent);
    
    anosDeProducao.push(ano);
    
    selecaoAnoInicial.appendChild(criaOpcaoDeAno(ano.getAno()));
    selecaoAnoFinal.appendChild(criaOpcaoDeAno(ano.getAno()));
  }

  // Atribui valores aos anos iniciais e finais 
  anoInicial = anosDeProducao[0].getAno();
  anoFinal   = anosDeProducao[anosDeProducao.length - 1].getAno();

  selecaoAnoFinal.value = anoFinal;
}
function apresentaRede(){
 
  var selecaoAnoInicial = document.querySelector("#ano-inicial");
  var selecaoAnoFinal   = document.querySelector("#ano-final");

  if(selecaoAnoInicial.value > selecaoAnoFinal.value){
    var auxiliar = selecaoAnoInicial.value;
    selecaoAnoInicial.value = selecaoAnoFinal.value;
    selecaoAnoFinal.value = auxiliar; 
  }

  apresentaArestasEntre(selecaoAnoInicial.value,selecaoAnoFinal.value);

}
function apresentaGrafo(){
  
  rede = new Rede(
    redeXML.querySelector("titulo").textContent,
    redeXML.querySelector("numeroDeProducoesUnicas").textContent,
    redeXML.querySelector("numeroDeNodos").textContent,
    redeXML.querySelector("numeroDeArestas").textContent,
    redeXML.querySelector("similaridadeMin").textContent,
    redeXML.querySelector("metrica").textContent,
  );




  listaDeNodos = [];
  apresentaDescritor();
  criaNodos(redeXML.querySelectorAll("nodo"));
  identificaAnosDaRede(redeXML.querySelector("anos"));
  
  criaArestas(redeXML.querySelectorAll("aresta"));
}