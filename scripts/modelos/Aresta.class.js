Aresta = function(origem, destino, peso){
	this.origem     = origem;
	this.destino    = destino; 
	this.duplicatas = [];
}

Aresta.prototype.getObjSpringy     = function(){ return this.objSpringy; }
Aresta.prototype.getOrigem         = function(){ return this.origem; }
Aresta.prototype.getDestino        = function(){ return this.destino; }
Aresta.prototype.getAno            = function(){ return this.ano;}
Aresta.prototype.getPeso  = function(anoInicial, anoFinal){ 
	var peso = 0;
	for (var i = 0; i < this.duplicatas.length; i++) {
		var ano = this.duplicatas[i].getAno();
		if(ano >= anoInicial && ano <= anoFinal) peso++;
	} 
	return peso;
}
// verifica se esta aresta é dos pesquisadores passados como parâmetro 
Aresta.prototype.verificaAresta = function(origem, destino){
	if((this.origem == origem && this.destino == destino)||
		(this.origem == destino && this.destino == origem)){
		return true;
	}
	return false; 
}
Aresta.prototype.getDuplicatas = function(){
	return this.duplicatas;
}



Aresta.prototype.setObjSpringy     = function(obj){ this.objSpringy = obj; }
Aresta.prototype.setPeso = function(peso){
	this.objSpringy.data.label = peso;
}



Aresta.prototype.addDuplicata = function(duplicata){ this.duplicatas.push(duplicata); }




Aresta.prototype.addPeso           = function(peso){this.peso += peso;}
Aresta.prototype.addAno            = function(ano) {this.anos.push(ano);}

Aresta.prototype.pesquisadoresIguais = function(aresta){
	if(aresta.getOrigem() == this.getOrigem() && aresta.getDestino() == this.getDestino())
		return true 
	return false
}