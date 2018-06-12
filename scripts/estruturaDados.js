var pesquisadoresSelecionados = []; 

function addPesquisadorLista(obj){
	pesquisadoresSelecionados.push(obj.value);
	obj.setAttribute("onclick","removePesquisadorLista(this);");
	exibeNodos();
}
function removePesquisadorLista(obj){
	for(var i = 0; i < pesquisadoresSelecionados.length; i++){
		if(pesquisadoresSelecionados[i] == obj.value){
			pesquisadoresSelecionados.splice(i,1);
			break;
		}
	}
	obj.setAttribute("onclick","addPesquisadorLista(this)");
	exibeNodos();
}
function exibeNodos(){
	var numeroDeSelecionados = pesquisadoresSelecionados.length;
	var divPesquisadoresSelecionados = document.querySelector("#pesquisadores-da-rede");
	divPesquisadoresSelecionados.innerHTML = "";
	
	var p = document.createElement("p");
	p.innerText = "* Numero de Selecionados: "+numeroDeSelecionados;
	divPesquisadoresSelecionados.appendChild(p);

	for(var i = 0; i < numeroDeSelecionados; i++){

		var p = document.createElement("p");
		p.innerText = document.querySelector("#pesquisador"+pesquisadoresSelecionados[i]).innerText;
		divPesquisadoresSelecionados.appendChild(p);
	}

}
function validaSimilaridade(e){
	console.log(e);
	if(e.keyCode < 48 || e.keyCode > 57){
		//console.log(this.value);
		this.value = this.value.substr(0,this.value.length -1);
		//document.querySelector("#similaridade").value = this.value.pop();
	}
}
function validaFormulario(){
	this.submit = false;
	return false;
}
document.querySelector("#form-criador-rede").addEventListener("submit", function(){
	
	var numeroDeSelecionados = pesquisadoresSelecionados.length;
	if(numeroDeSelecionados > 1){
		var pesquisadores = "";
		
		for(var i = 0; i < numeroDeSelecionados; i++){
			pesquisadores += pesquisadoresSelecionados[i]+";";
		}

		var input = document.createElement("input");
		input.type = "hidden";
		input.value = pesquisadores;
		input.name = "pesquisadores";
		document.querySelector("#form-criador-rede").appendChild(input);

		var input = document.createElement("input");
		input.type = "hidden";
		input.name = "requisicao";
		input.value = "ConstrutorDeRedes";
		document.querySelector("#form-criador-rede").appendChild(input);

		return true; 
	}
	return false;
});