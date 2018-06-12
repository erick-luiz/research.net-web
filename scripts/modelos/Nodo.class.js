Nodo = function(idLattes, label, dataDeAtualizacao, numeroDeProducoes){
	this.idLattes = idLattes;
	this.label = label;
	this.nome = label;
	this.dataDeAtualizacao = dataDeAtualizacao;
	this.numeroDeProducoes = numeroDeProducoes;
	this.anos = [];
	this.producoes = [];
	this.objSpringy = null;
	this.grau = 0;
}
Nodo.prototype.addProducao = function(producao){ this.producoes.push(producao);}
Nodo.prototype.addAno      = function(ano){ this.anos.push(ano);}


Nodo.prototype.getObjSpringy = function(){ return this.objSpringy; }
Nodo.prototype.getLabel = function(){ return this.label; }
Nodo.prototype.getId = function(){ return this.idLattes;}
Nodo.prototype.getDataAtualizacao = function(){
	$retorno = this.dataDeAtualizacao[0]+this.dataDeAtualizacao[1];
	$retorno += "/"+this.dataDeAtualizacao[2]+this.dataDeAtualizacao[3];
	$retorno += "/"+this.dataDeAtualizacao[4]+this.dataDeAtualizacao[5];
	$retorno += ""+this.dataDeAtualizacao[6]+this.dataDeAtualizacao[7];
	return $retorno;
}
Nodo.prototype.getDescricao = function(anoInicial, anoFinal) {
	var texto = "Nome: " + this.nome + "\n";
	texto += "id Lattes: " + this.getId() + "\n";
	texto += "Última atualização: " + this.getDataAtualizacao() + "\n";
	texto += "Dados de "+ anoInicial + " à " + anoFinal + "\n";
	texto += "Grau do Nodo: " + this.grau + "\n";
	texto += "Número de Produções: " + this.getNumeroDeProducoesEntre(anoInicial, anoFinal) + "\n";
	return texto;
}
Nodo.prototype.getNumeroDeProducoesEntre = function(anoInicial, anoFinal){
	var total = 0;
	for(var i = 0; i < this.anos.length; i++){
		if(anoInicial <= this.anos[i].getAno() && this.anos[i].getAno() <=anoFinal){
			total += this.anos[i].getNumeroDeProducoes();
		}
	}
	return total;
}
Nodo.prototype.getTotalDeProducoes = function(){ return this.producoes.length; }

Nodo.prototype.setObjSpringy = function(obj){ this.objSpringy = obj; }
Nodo.prototype.setGrau = function(grau, aumento = false){ 
	if(aumento) this.grau += grau;
	else this.grau = grau; 
}
Nodo.prototype.ajustaLabel = function(anoInicial, anoFinal){
	this.objSpringy.data.label = this.getLabel() + " (" 
	+ this.getNumeroDeProducoesEntre(anoInicial, anoFinal) + ")";
}
Nodo.prototype.getLabelAjustado = function(){
	var auxiliar = this.label.split(" ");
	var retorno = auxiliar[0];
	for(var i = 1; i < auxiliar.length; i++){
		if(auxiliar[i] == "de" || auxiliar[i] == "da") continue; 
		retorno += " "+auxiliar[i][0]+".";
	}
	return retorno;
}
