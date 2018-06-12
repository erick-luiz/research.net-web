var productions;
var allProdutions = [];

var getProductions = (function (){
	
	$.ajax({
	    url : "http://localhost/research.net/src/app/modelos/GetProductions.class.php",
	    type : 'post',
	    data : {
	        idResearcher : $('#viewerOfProductions').val()
	    },
	    beforeSend : function(){
	        $("#resultado").html("ENVIANDO...");
	    }
	})
	.done(function(msg){
		productions = JSON.parse(msg);
		showDataProdutcions();
	})
	.fail(function(jqXHR, textStatus, msg){
	    alert(msg);
	});
});

var showDataProdutcions = (function(){
		
	var liDate = $('#li-date');
	var liProduction = $('#li-production');
	var spanLength = $('#span-date');
	var resultList = $('#resultGetProductions');
	resultList.empty();
	var totalProds = $('#total-produtions');
	var total = 0;
	
	var anoInicial = $('#ano-inicial').val();
  	var anoFinal   = $('#ano-final').val();

	for (var i = 0; i < productions["years"].length; i++) {
		if(parseInt(productions["years"][i]) >= parseInt(anoInicial) && parseInt(productions["years"][i]) <= parseInt(anoFinal)){

			var aux = liDate.clone();
			aux.html(productions["years"][i]);
			aux.removeAttr("id");
			aux.removeAttr("style");

			var span = spanLength.clone();
			span.html(productions[productions["years"][i]].length);
			span.removeAttr("id");
			span.removeAttr("style");

			total += productions[productions["years"][i]].length;

			resultList.append(aux.append(span));

			for(var j = 0; j < productions[productions["years"][i]].length; j++){
				var title = liProduction.clone();
				title.html(productions[productions["years"][i]][j]);
				allProdutions.push(productions[productions["years"][i]][j]);
				title.removeAttr("id");
				title.removeAttr("style");
				resultList.append(title);
			}
			var name = $('#viewerOfProductions option[value='+$('#viewerOfProductions').val()+']').html();
			totalProds.html(total + " É o total de produções do pesquisador" +name+ " de " + anoInicial + " à " + anoFinal);
		}
	}
});

$('#viewerOfProductions').change(getProductions);
