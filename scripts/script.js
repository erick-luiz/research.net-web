function confereTamanhoCurriculos(form){
  event.preventDefault();
  var curriculos = document.querySelector("#curriculoXML");
  if(curriculos.files.length > 20){
    alert("Só é possivel enviar 20 currículos por vez!");
    return false;
    form.submit();
  }
  
  var tamanhoTotal = 0;
  for (var i = 0; i < curriculos.files.length; i++) {
    tamanhoTotal += curriculos.files[i].size;
  }
  if(tamanhoTotal < document.querySelector("#tamanho-curriculo").value){
    form.submit();
    return true;
  }else{
    alert("Possivelmente muitos curriculos foram selecionados! O tamanho total exedeu o limite aceito");
    return false;
  }
}


function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Funções do filtro 
function myFunction2() {
  // Declare variables 
  var input, filter, table, tr, td, i, tipoDeConsulta;

  // Recebe o tipo de consulta pretendida (ex: por instituição, por titulo, etc...)
  tipoDeConsulta = document.querySelector('input[type=radio][name=tipo-consulta]:checked').value;

  input  = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table  = document.getElementById("myTable");
  tr     = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    console.log(tr.length);

    td = tr[i].getElementsByTagName("td")[tipoDeConsulta];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}