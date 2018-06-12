Ano = function(ano, numeroDeProducoes){
	this.ano = ano; 
	this.numeroDeProducoes = numeroDeProducoes; 
}

Ano.prototype.getAno = function(){ return this.ano;}
Ano.prototype.getNumeroDeProducoes = function(){ return parseInt(this.numeroDeProducoes); }