<div class="container">
	<div class="row">
		<div id="descritor"></div>
		<div id="modos-visualizacao" class="container">
			<br/>
			<ul class="list-group">	

				<li class="list-group-item" >
					Nodos
					<span class="badge badge-primary badge-pill" id="numero-de-nodos"></span>
				</li>
				<li class="list-group-item" >
					Arestas
					<span class="badge badge-primary badge-pill" id="numero-de-arestas"></span>
				</li>
				<li class="list-group-item" >
					Produções 
					<span class="badge badge-primary badge-pill" id="numero-de-producoes"></span>
				</li>
				<li class="list-group-item" >
					Métrica  
					<span class="badge badge-pill badge-info" id="metrica"></span>
				</li>
				<li class="list-group-item" >
					Similaridade Mínima
					<span class="badge badge-pill badge-info" id="similaridade-minima"></span>
				</li>
			</ul>
			
			<form>	  
			  <div class="form-group">
			    <label for="modeViewer">Modo de vizualização</label>
			    <select class="form-control" id="modeViewer">
			    	<option value="verDuplicata">ver duplicata</option>
					<option value="verInfo">ver informações</option>
			    </select>
			  </div>
			</form>
		</div>
	</div>
	
	<div id="anos" class="container">
		<form class="form-inline">	  
		  	<div class="form-group col-sm-3">
		    	<label for="ano-inicial" style="padding-right: 1em;">Ano Inicial </label>
		    	<select class="form-control"  name="ano-inicial" id="ano-inicial">
		    	</select>
			</div>	
			
			<div class="form-group col-sm-3">
		    	<label for="ano-final" style="padding-right: 1em;">Ano Final </label>
		    	<select class="form-control" name="ano-final" id="ano-final">
		    	</select>
		  	</div>
		</form>
	</div>
</div>	

<div id="apresentacao-grafo" class="row">
	<canvas id="area-de-apresentacao" width="880" height="400" />
</div>
<hr>

