Intervalo = function(anoInicio, anoFinal){
	this.anoInicio = anoInicio;
	this.anoFinal  = anoFinal; 
	this.arestas   = [];
}

Intervalo.prototype.addAresta = function(aresta, grafo){ 
	this.arestas.push(aresta);
	var novaAresta = false;
	for (var i = 0; i <this.arestas.length ; i++) {
		if(this.arestas[i].pesquisadoresIguais(aresta)){
			novaAresta = arestas[i];
			break;
		}
	}
	if(novaAresta){
		novaAresta.addPeso(aresta.getPeso());
		novaAresta.addAno(aresta.getAno());
	}else{
		var novaAresta = new Aresta(aresta.getOrigem(),
									aresta.getDestino(),
									aresta.getPeso(),
									aresta.getAno()
							);
		novaAresta.setObjSpringy(grafo.newEdge(
      	aresta.getOrigem(),
      	aresta.getDestino(),
     	{label:aresta.getPeso(),directional:false}));
	}

}
Intervalo.prototype.getArestas = function(){
	for (var i = 0; i <this.arestas.length ; i++) {
		
	}
}
