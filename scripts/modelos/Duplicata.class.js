Duplicata = function(id, indice, ano, titulo1, titulo2){
	this.id      = id; 
	this.indice  = indice;
	this.ano     = ano;
	this.titulo1 = titulo1;
	this.titulo2 = titulo2;
}

Duplicata.prototype.getAno = function(){ return this.ano; }
Duplicata.prototype.getIndice = function(){ return this.indice; }
Duplicata.prototype.getId = function(){ return this.id; }
Duplicata.prototype.getTitulo1 = function() { return this.titulo1; }
Duplicata.prototype.getTitulo2 = function() { return this.titulo2; }