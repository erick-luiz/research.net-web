Rede = function(titulo, numeroDeProducoes, numeroDeNodos, numeroDeArestas, similaridadeMin, metrica){
	this.titulo            = titulo;
	this.numeroDeProducoes = numeroDeProducoes;
	this.numeroDeNodos     = numeroDeNodos;
	this.numeroDeArestas   = numeroDeArestas;
	this.similaridadeMin   = similaridadeMin;
	this.metrica           = metrica;
	
	this.nodos   = [];
	this.arestas = [];
	this.anos    = [];
}
Rede.prototype.addNodo = function(nodo){ this.nodos.push(nodo);}
Rede.prototype.addAresta = function(aresta){ this.arestas.push(aresta); }
Rede.prototype.addAno = function(ano){ this.anos.push(ano); }

Rede.prototype.getTitulo = function(){ return this.titulo;}
Rede.prototype.getNumeroDeProducoes = function(){ return this.numeroDeProducoes;}
Rede.prototype.getNumeroDeNodos = function() { return this.numeroDeNodos; }
Rede.prototype.getSimilaridadeMin = function(){ return this.similaridadeMin;}
Rede.prototype.getMetrica = function(){ return this.metrica;}
Rede.prototype.getNumeroDeArestas = function() { return this.arestas.length; }
Rede.prototype.getNodoComIdLattes = function(id, obj = true){
	for(var i = 0; i < this.nodos.length; i++){
		if (this.nodos[i].getId() == id){
			if(obj) return this.nodos[i].getObjSpringy();
			return this.nodos[i];
		}
	}
	return null;
}
// Retorna aresta entre dois nodos passados como parâmetro 
Rede.prototype.getArestaDeNodos = function(nodoA, nodoB){
	for (var i = 0; i < this.arestas.length; i++) {
		console.log(nodoA);
		if(arestas[i].verificaAresta(nodoA, nodoB)){
			return arestas[i];
		}
	}
	return null;
}
// Verifica a existencia de aresta entre dois pesquisadores 
Rede.prototype.verificaAresta = function(aresta){
	for (var i = 0; i < this.arestas.length; i++) {
		if(arestas[i].pesquisadoresIguais(aresta)) return arestas[i];
	}
	return false;
}

Rede.prototype.getArestasEntre = function(anoInicial, anoFinal){
	var retorno = [];
	for(var i = 0; i < this.arestas.length; i++){
		var peso = this.arestas[i].getPeso(anoInicial, anoFinal);
		if(peso > 0){
			this.arestas[i].setPeso(peso);
			retorno.push(this.arestas[i]);
		}
	}
	return retorno;
}

Rede.prototype.reinicializaGrauNodos = function(){
	for (var i = 0; i < this.nodos.length; i++) {
		this.nodos[i].setGrau(0);
	}
}


Rede.prototype.ajustaLabelDosNodos = function(anoInicial, anoFinal){
	for(var i = 0; i < this.nodos.length; i++){
		this.nodos[i].ajustaLabel(anoInicial, anoFinal);
	}
}