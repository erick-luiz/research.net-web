<?php
	class AreaDoConhecimento{
		function __construct($grandeArea = "", $area = "", $subArea = "", $especialidade = ""){
			$this->grandeArea = $grandeArea; 
			$this->area = $area; 
			$this->subArea = $subArea;
			$this->especialidade = $especialidade; 
		}
		function getGrandeArea(){ return $this->grandeArea; }
		function getArea() { return $this->area; }
		function getSubArea() { return $this->subArea; }
		function getEspecialidade() { return $this->especialidade; }

		function verificaIgualdade($areaDoConhecimento){
		
			if($this->grandeArea != "" && $areaDoConhecimento->getGrandeArea() != ""){
				$afirmativa = $this->grandeArea == $areaDoConhecimento->getGrandeArea();
			}else{
				$indefinido = true; 
			}
			if($this->area != "" && $areaDoConhecimento->getArea() != ""){
				if($indefinido){
					$afirmativa = true; 
					$indefinido = false; 
				}
				$afirmativa = $afirmativa && ($this->area == $areaDoConhecimento->getArea()); 
			}
			if($this->subArea != "" &&  $areaDoConhecimento->getsubArea() != ""){
				if($indefinido){
					$afirmativa = true; 
					$indefinido = false; 
				}
				$afirmativa = $afirmativa && ($this->subArea == $areaDoConhecimento->getsubArea()); 
			}
			if($this->especialidade != "" && $areaDoConhecimento->getEspecialidade() != ""){
				if($indefinido){
					$afirmativa = true; 
					$indefinido = false; 
				}
				$afirmativa = $afirmativa && ($this->especialidade == $areaDoConhecimento->getEspecialidade()); 
			}
			if($indefinido) $afirmativa = true;
			return $afirmativa; 
		}
	}	
?>