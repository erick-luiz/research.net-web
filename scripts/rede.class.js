// Classe rede 
Rede = function (descritor, nodos = null, arestas = null){
	this.descritor = descritor;
	this.nodos     = nodos;
	this.arestas   = arestas;

	this.nodos_removidos = [];
}

		//##########################################
		//# Retorno de Valores dos Atributos (get) #
		//##########################################

// Método da classe Rede para retornar o tipo 
Rede.prototype.getTipo = function () {
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["tipo_de_rede"];
	}else{
		return "Tipo Indefinido!";
  	}
}
// Método da classe Rede para retornar nome 
Rede.prototype.getNome = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["nome_da_rede"];
	}else{
		return "Nome Indefinido!";
	}
}
// Método da classe Rede para retornar o número de nodos da rede  
Rede.prototype.getNumNodos = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["num_de_nodos"];
	}else{
		return "Numero de nodos Indefinido!";
	}
}
// Método da classe Rede para retornar o número de arestas da rede  
Rede.prototype.getNumArestas = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["num_de_arestas"];
	}else{
		return null;
	}
}
// Método da classe Rede para retornar a instituicao  
Rede.prototype.getInstituicao = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["instituicao"];
	}else{
		return "Indefinido";
	}
}
// Método da classe Rede para retornar a unidade da rede   
Rede.prototype.getUnidade = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["unidade"];
	}else{
		return "Indefinido";
	}
}
// Método da classe Rede para retornar o grupo de pesquisa da rede   
Rede.prototype.getGrupoDePesquisa = function(){
	if(typeof this.descritor !==  "undefined"){
		return this.descritor["grupo_de_pesquisa"];
	}else{
		return "Indefinido";
	}
}
// Método da classe Rede para retornar os nodos da rede
Rede.prototype.getNodos = function(){
	if(typeof this.nodos !==  "undefined"){
		return this.nodos;
	}else{
		return null;
	}
}
// Método da classe Rede para retornar um nodo a partir do id
Rede.prototype.getNodoId = function(id){
	if(typeof id !== "undefined"){
		return this.nodos_springy[id];
	}
	return null;
}
// Método da classe Rede para retornar os nodos da rede
Rede.prototype.getArestas = function(){
	if(typeof this.arestas !==  "undefined"){
		return this.arestas;
	}else{
		return null;
	}
}
// Método da classe Rede para retornar os nodos da rede no formato da biblio Springy 
Rede.prototype.getNodosSpringy = function(){
	if(typeof this.nodos_springy !==  "undefined"){
		return this.nodos_springy;
	}else{
		return null;
	}
}
// Retorna os nodos cujo o valor do grau é zero 
Rede.prototype.getNodosGrauZero = function(){

	var retorno = [];
	this.nodos_springy.forEach(function(value,index){
		if(value["data"]["grau"] == 0){
			retorno[index] = value;
		}
	});
	return retorno;
}
Rede.prototype.getNodoGrau = function(id){
	return this.nodos_springy[id]["data"]["grau"];
}
// Retorna um array com as arestas criadas em springy 
Rede.prototype.getArestasSpringy = function(){
	return this.arestas_springy;
}
Rede.prototype.getNodoRemovidos = function(){
	return this.nodos_removidos;
}
		//###########################################
		//# Atribuiçõe de Valores aos Atributos Put #
		//###########################################

// Método da classe Rede para receber nodos no formato springy
Rede.prototype.putNodosSpringy = function(nodos){
	this.nodos_springy = nodos;
}
// Método da classe Rede para receber nodos
Rede.prototype.putNodos = function(nodos){
	this.nodos = nodos;
}
// Método da classe Rede para receber arestas no formato springy
Rede.prototype.putArestasSpringy = function(arestas){
	this.arestas_springy = arestas;
}
// Método da classe Rede para receber arestas
Rede.prototype.putArestas = function(arestas){
	this.arestas = arestas;
}
Rede.prototype.putNodoRemovidos = function(id){
	this.nodos_removidos[id] = this.nodos_springy[id];
}
		//#######################################################
		//# remoção de Valores dos atributos                    #
		//#######################################################

Rede.prototype.removeNodoRemovidos = function(id){
	this.nodos_removidos[id].pop(id);
}

		//#######################################################
		//# Confere Existência de valores dos aos Atributos     #
		//#######################################################	

Rede.prototype.confereNodoRemovido = function(){
	if(typeof this.nodos_removidos !==  "undefined"){
		return true;
	}else{
		return false;
	}
}