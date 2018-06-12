var lista_de_0 = [], grafo, redes = [], redeAtivada = 0;
 
function config_nodo_isolado(){
	
	var nodo_isolado = $("#nodoIsolado").prop("checked");

	if (!nodo_isolado){
		// Confere se o número de arestas é zero, se sim apaga o grafo inteiro 
		// Caso contrário, apaga apenas nodos com grau zero
		if(redes[redeAtivada].getNumArestas()==0){
			apaga_grafo();
		}else{
			remove_lista_de_nodos(grafo,redes[redeAtivada].getNodosGrauZero());
		}
	}else{
		// Se o numéro de arestas é zero, desenha o grafo inteiro novamente 
		// Caso contrário, desenha apenas os nodos de grau zero 
		if(redes[redeAtivada].getNumArestas()==0){
			add_lista_de_nodos(grafo, redes[redeAtivada].getNodosSpringy());
		}else{
			add_lista_de_nodos(grafo,redes[redeAtivada].getNodosGrauZero());
		}
	}
}
// Muda classe do botão acionado e desenha novo grafo 
function aciona_rede(index){
	
	// Muda a classe do botão da rede ativada para desmarca-lo
	var id = "#botao_menu_lateral" + redeAtivada;
	$(id).removeClass("btn btn-default btn-block active").addClass("btn btn-default btn-block");
	
	// Troca a classe do botão da rede requisitada, para marca-lo  
	var id = "#botao_menu_lateral" + index;
	$(id).removeClass("btn btn-default btn-block").addClass("btn btn-default btn-block active");
	
	// Apaga o grafo para desenhar a nova rede 
	apaga_grafo();

	// Atualiza a variável global que define a rede que está ativada no momento 
	redeAtivada = index;
	
	// Desenha a nova rede 
	apresenta_grafo(redeAtivada);
}
// Salvar imagem 
function salvar_imagem(nome){
   
   var meucanvas = document.getElementById('redeColaboracao');
   var arquivo = document.getElementById('arquivo');
   /*Comentário: a variavel "a" será o nome do arquivo, use aspas para chamar a função */
   arquivo.download = nome;
   arquivo.href = meucanvas.toDataURL();
}

// Cria botões do menu lateral com o nome das redes lidas 
function apresenta_botoes_menu_lateral(tipo_de_rede, nome_da_rede, valor, i){ 
	var ativado = "";
	if(i == 0) {
		ativado = "active";
		redeAtivada = valor;
	}
	if(tipo_de_rede == "publica"){
		// Botões da rede pública ficam na Div #redes_publicas
		$("#redes_publicas").append("<button type='button' onclick='aciona_rede("+valor+");' name='btn_menu_lateral' id='botao_menu_lateral"+valor+"' value='"+valor+"' class='btn btn-default btn-block " +ativado+"'>"+nome_da_rede+"</button>");
	}else{
		// Botões da rede privada ficam na Div #redes_privadas
		$("#redes_privadas").append("<button name='btn_menu_lateral' type='button' onclick='aciona_rede("+valor+");' id='botao_menu_lateral"+valor+"' value='"+valor+"' class='btn btn-default btn-block'>"+nome_da_rede+"</button>");
	}
}
// Apresenta os nodos no grafo na sessão Nodos da Rede 
function apresenta_nodos_da_rede(index){
	$("#Nodos_da_rede").empty();
	redes[index].getNodosSpringy().forEach(function(value,index){
		// Escreve na sessão nodos da rede 
		$("#Nodos_da_rede").append("<ul><li>"+value['data']['label']+"</li><ul><li><a href='"+value['data']['linkLattes']+"'>Link para Lattes</a></li><li>Numero de Publicações: "+value['data']['nPublicacoes']+"</li><li>Grau do nodo: "+value['data']['grau']+"</li><li>pageRank: "+value['data']['pageRank']+"</li><li>clusterCoeficient: "+value['data']['clusterCoeficient']+"</li><li>Clossenes: "+value['data']['clossenes']+"</li></ul></ul>");
	});
}
// Apresenta Descrição da rede 
function apresenta_descricao_da_rede(index){

	// Remove o título da rede anterior 
	$('#TituloRede').empty();
	// Insere o Título da rede ativada 
	$('#TituloRede').append(redes[index].getNome());
	// Limpa a área de informações da rede 
	$('#info_rede').empty();
	// Insere as informações da rede ativada 
	$('#info_rede').append("<br><table class='table table-hover table-striped'><tr><th>Atributos</th><th>valores</th></tr><tr><td>Nome da Rede</td><td>"+redes[index].getNome()
		+"</td></tr><tr><td>Numero de nodos </td><td>"+redes[index].getNumNodos()
		+"</td></tr><tr></td><td>Numero de Arestas </td><td>"+redes[index].getNumArestas()
		+"</td></tr><tr><td>Instituição </td><td>"+redes[index].getInstituicao()
		+"</td></tr><tr><td>Unidade </td><td>"+redes[index].getUnidade()
		+"</td></tr><tr><td>Grupo de Pesquisa </td><td>"+redes[index].getGrupoDePesquisa()
		+"<br>"
		);
}
// Apresenta o grafo na tela (canvas)
function apresenta_grafo(index, aux = 0){
	

	// Apresenta a descrição da rede 
	apresenta_descricao_da_rede(index);
	
	apresenta_nodos_removidos();

	// os nodos da rede só são inseridos na descrição uma vez 
	// por isso utilizamos o 'aux' para definir quando NÃO devemos apresentar os nodos 
	if(aux == 0){apresenta_nodos_da_rede(index);}

	// Adicionas os nodos que devem ser apresentados ao grafo 
	add_lista_de_nodos(grafo,redes[index].getNodosSpringy());

	// Se exixtirem arestas, adiciona as arestas ao grafo 
	if(redes[index].getNumArestas()>0){
		add_lista_de_arestas(grafo,redes[index].getArestasSpringy());
	}

	// Verifica se os nodos isolados devem ser ou não apresentados 
	config_nodo_isolado();

	// Verifica se exitem nodos removidos ou não da lista 
	if(redes[redeAtivada].confereNodoRemovido()){
		remove_lista_de_nodos(grafo, redes[index].getNodoRemovidos());
	}
}
// Apresenta o modal com as informações e opções do nodo 
function apresenta_modal(){

	// Limpa o corpo do Modal 
	$('#corpo_modal').empty();
	// Insere o Label do nodo ao Modal  
	$('#corpo_modal').append(JSON.stringify(node.data.label));
	// Pega o id do nodo selecionado 
	var id = JSON.stringify(node.data.id);
	alert(id);
	// Insere a opção de remover o nodo da apresentação do grafo 
	$('#corpo_modal').append("<form role='form'><input type='checkbox' name='nodo_remove' value='0' id='nodo_remove' onclick='removeNodoId("+id+")'> Deixar de Exibir o Nodo</form>");	    		
	// Apresenta o Modal (REVER)
	$('#myModal').modal({
  		keybord:false
	});
}
// Apresenta nodos removidos 
function apresenta_nodos_removidos(){

	var removidos = redes[redeAtivada].getNodoRemovidos();
	var tamanho = removidos.length;
	$("#lista_nodos_removidos").empty();
	if(tamanho > 0){
		$("#lista_nodos_removidos").append("<li>  Clique para exibir  </li>");
	}else{
		$("#lista_nodos_removidos").append("<li>  Sem nodos removidos  </li>");
	}
	$("#lista_nodos_removidos").append("<li class='divider'></li>");

	removidos.forEach(function(value, index){
		$("#lista_nodos_removidos").append("<li><button class='btn btn-default btn-block'  onclick='removeNodoId("+value["data"]["id"]+","+true+")'><em class='glyphicon glyphicon-eye-open'></em> "+reduz_nome(value["data"]["label"])+"</button></li>");
	});
}
//######################################################################################
//                          CRIAÇÕES E ADIÇÕES  (LISTAS, OBJETOS, ETC)                 #
//######################################################################################

// Cria nodos pela Biblioteca  springy e retorna a lista de nodos criados 
function cria_nodos(rede, grafo){
	
	// inicializa lista de nodos 
	var retorno = [];

	// Percorre os nodos da rede 
	rede.getNodos().forEach(function(value,index){
		
		// Cria um nodo com a biblioteca Springy
		var x = grafo.newNode({label:value["nome"],id:value["id"] ,linkLattes: value['linkLattes'] , nPublicacoes:value['nPublicacoes'] ,grau:value["grau"],pageRank:value['pageRank'],clusterCoeficient:value['clusterCoeficient'], clossenes:value['clossenes'],
				ondoubleclick: function(){
					apresenta_modal();
				}
			});
		
		// Guarda o nodo na lista de nodos
		retorno[value['id']] = x;
		
	});

	//retorna lista de nodos criados 		
	return retorno;
}
// Cria arestas pela Biblioteca springy e retorna a lista de arestas criadas 
function cria_arestas(rede, graph){
	
	// Inicializa a lista de arestas 
	var retorno = [];
	
	// Percorre a lista de arestas da rede  
	rede.getArestas().forEach(function(value, index){
		
		// A partir dos id's dos nodos ele cria as arestas 
		y = graph.newEdge(
			rede.getNodoId(value["destino"]),
			rede.getNodoId(value["origem"]),
			{color: '',label:value['valor'],directional:false}
		);
		
		// Insere a arestas na lista a ser retornada 
		retorno[index] = y;
	});

	// Retorna a lista de arestas criadas 
	return retorno;
}
// Adiciona um nodo, já criado, ao Grafo 
function add_nodo(grafo,nodo){
	grafo.addNode(nodo);
}
// Adiciona uma lista de nodos ao Grafo
function add_lista_de_nodos(grafo,lista){
	lista.forEach(function(value,index){
		add_nodo(grafo,value);
	});
}
// Adiciona uma aresta ao Grafo 
function add_aresta(grafo,aresta){
	grafo.addEdge(aresta);
}
// Adiciona uma lista de arestas ao Grafo
function add_lista_de_arestas(grafo,lista){
	lista.forEach(function(value,index){
		add_aresta(grafo,value);
	});
}


//######################################################################################
//                          REMOÇÕES E ELIMINAÇÕES (LISTAS, OBJETOS, ETC)              #
//######################################################################################

// Função para remover o nodo selecionado ou coloca-lo de volta 
// Caso você deseje desabilitar um nodo da rede, poderá remove-lo 
function removeNodoId(id, aux = false){
	
	if(!aux){
		// Verifica se o input com o id nodo_remove esta checado ou não 
		var ativado = $("#nodo_remove").prop("checked");
	}else{
		var ativado = false;
	}
	// Se estiver checado remove o nodo ('Deixar de exibir nodo')
	// Se não ele volta a exibir o nodo 
	if(ativado){
		redes[redeAtivada].putNodoRemovidos(id);
		apresenta_grafo(redeAtivada, 1);
	}else{
		redes[redeAtivada].removeNodoRemovidos(id);
		apresenta_grafo(redeAtivada, 1);
	}
}		
// Não permite que determinado texto seja selecionado 
function removeSelecao(){
	if (window.getSelection) {
		window.getSelection().removeAllRanges();
	}
}
// Remove um nodo do Grafo
function remove_nodo(grafo, nodo){
	grafo.removeNode(nodo);
}
// Remove uma lista de nodos do Grafo 
function remove_lista_de_nodos(grafo, lista){
	lista.forEach(function(value,index){
		remove_nodo(grafo,value);
	});
}
// Remove todos nodos que estão sendo apresentados, isso apaga o grafo que está sendo exibido 
function apaga_grafo(){
	remove_lista_de_nodos(grafo,redes[redeAtivada].getNodosSpringy());
}

//######################################################################################
//                          EDIÇÕES DE TEXTO                                           #
//######################################################################################

function reduz_nome(string){
	var retorno = string.split(" ");
	var tamanho = retorno.length; 
	var nome = retorno[0];
	var i = 1;
	while(i < tamanho){
		nome = nome + " " + retorno[i][0]+ ".";
		i = i + 1; 
	}
	return nome;
}




//######################################################################################
//                          FUNÇÃO PRINCIPAL  (LISTAS, OBJETOS, ETC)                   #
//######################################################################################

function principal(inicio = 0){

	var i = 0;

	// Inicializa um novo grafo da biblioteca Springy
	var graph = new Springy.Graph();

	// Estrutura Jquery para processar os dados e criar os nodos e arestas 
	$(function(){

		// Pega os dados json da div dados e os insere na variavel de dados
		var dados =	$("#dados").html();
		
		// Transforma os dados em formato de Objeto 
		var dados_tratados = JSON.parse(dados);

		// Itera as redes, cada index será o identificador da rede lida 
		dados_tratados.forEach(function(rede, index){
			
			// Instância uma nova rede 
			var rede = new Rede(rede["descritor"],rede["nodos"],rede["arestas"]);				
			
			if(inicio == 1){
				// Index será o value atribuido ao Botão 					
				apresenta_botoes_menu_lateral(rede.getTipo(), rede.getNome(), index, i);
				i = 1;
			}

			// Cria os nodos do gráfico e retorna o array de nodos  
			if(rede.getNumNodos()>0){
				rede.putNodos(rede["nodos"]);
				var nodos_springy = cria_nodos(rede, graph);
				rede.putNodosSpringy(nodos_springy);
			}

			// Confere se existem arestas através do descritor 
			if(rede.getNumArestas() > 0){
				rede.putArestas(rede["arestas"]);
				var arestas_springy = cria_arestas(rede, graph);
				rede.putArestasSpringy(arestas_springy);
			}
			remove_lista_de_nodos(graph, rede.getNodosSpringy());
			
			redes[index] = rede;
		});

		grafo = graph;
		apresenta_grafo(0);
		aciona_rede(0);
	  	

	  	var springy = window.springy = jQuery('#redeColaboracao').springy({
	    graph: graph,
	    	nodeSelected: function(){
	    	}
			
		});
	});
}
