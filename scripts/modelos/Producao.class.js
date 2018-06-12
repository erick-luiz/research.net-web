Producao = function(titulo, ano, idAresta){
	this.titulo   = titulo; 
	this.ano      = ano; 
	this.idAresta = idAresta; 
}

Producao.prototype.getTitulo   = function(){ return this.titulo; }
Producao.prototype.getAno      = function(){ return this.ano; }
Producao.prototype.getIdAresta = function(){ return this.idAresta; }