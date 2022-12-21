var palabra=0;
var descripcion=0;

function crearActividad(idHistoria, idTipo){
	let id_historia = document.getElementById('idHistoria').value;
	let id_tipo = document.getElementById('idTipo').value;
	let id_grupo = document.getElementById('idGrupo').value;

	//alert("tipo: " +idTipo + "historia:" + idHistoria);

	$.ajax({
		url: 'actionAddActividad.php',
		type: 'POST',
		data: {
			accion: "guardar",
			idHistoria: idHistoria,
			idTipo: idTipo
		},
		success: function(Resultado) {
			//alert(Resultado);
			var resJSON = JSON.parse(Resultado);
			//alert(resJSON);
		},
		error: function (data) {
			// body...
		}
	});
}

function guardarTextCrucigrama()
{	
	let id_historia = document.getElementById('idHistoria').value;
	let id_grupo = document.getElementById('idGrupo').value;
	let id_tipo=document.getElementById('idTipo').value;
	let idActividad  = $('#idActv').val();
	let nom_act = $('#nom_act').val();
	let contenido = $('#editorOne').wysiwyg().html();
	//alert("hola: "+nom_act+" "+contenido); 
	if(nom_act == "" || contenido =="") {
		Swal.fire("Los campos no pueden quedar vacíos"); 
   	}else{
	    $.ajax({
			url: 'actionAddCrucigrama.php',
			type: 'POST',
			data: {
				accion: "guardarCruci",
				idActv: idActividad,
				nom_act: nom_act,
				contenido : contenido
			},
			success: function(Resultado) {
				// body...
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				Swal.fire(resJSON.mensaje);
				window.location.replace("../tables/nom_clase.php?idGrupo="+id_grupo);
			},
			error: function (data) {
				// body...
			}
		});
	}
}

function guardarPalabra() {
	//var id=7;
	let idCrucigrama  = $('#idActv').val();
	palabra = $('#palabra').val();
	descripcion = $('#desc').val();
	var tabla = $('#datatable').DataTable();
	//alert("Hola: " + palabra +" :"+descripcion + " :" + idCrucigrama);
	if(palabra == "" || descripcion == ""){
		Swal.fire("Completa todos los campos");
	}else{
		$.ajax({
			url: 'actionAddPalabra.php',
			type: 'POST',
			data: {
				palabra : palabra,
				desc : descripcion,
				idActv : idCrucigrama,
				accion : 'guardarPaCruci'
			},
			success: function(Resultado){
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					id=resJSON.id;
					var botonActualizar = '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('+id+')"><i class="fa fa-edit"></i></button></td>';
					var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
					tabla.row.add([
						palabra,
						descripcion,
						botonActualizar,
						botonEliminar
						]).draw().node().id="row_"+id;
				}
				Swal.fire(resJSON.mensaje); 
			}, 
			error: function(data){

			}
		});
	}
	idcru.reset();
}

function IdentificaActualizar(id) {
	// body...
	idActualizar=id;
	leerJeopardy();
}

function updatePalabraC(){
	palabra = document.getElementById("updateP").value;
	descripcion = document.getElementById("updateDesc").value;
	let idCruci = $('#idActv').val();
	var tabla = $("#datatable").DataTable();
	id= idActualizar;
	if(palabra == "" || descripcion == ""){
		Swal.fire("Completa todos los campos"); 
	}else{
		$.ajax({
			url: 'actionUpdatePalabra.php',
			type: 'POST',
			data: {
				palabra:palabra,
				descripcion:descripcion,
				idActv : id,
				accion:'actualizar'},
			success: function(Resultado) {
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					var temp = tabla.row('#row_'+id).data();
					temp[0]=palabra;
					temp[1]=descripcion;
					tabla.row('#row_'+id).data(temp).draw();
				}
				Swal.fire(resJSON.mensaje); 
			},
			error: function (data) {
				// body...
				Swal.fire("Ocurrió un error");
			}

		});
	}
	idcru.reset();
}

function IdentificaEliminar(id) {
	// body...
	idEliminar=id;
	mostrarPregunta();	
}

function deleteCrucigrama(){
	tabla = $('#datatable').DataTable();
	id= idEliminar;
	//alert(id);
	$.ajax({
		url: "actionDeletePalabraC.php",
		type: "POST",
		data: {
			id:idEliminar, 
			accion:'eliminar'},
		success: function(Resultado){
			//alert(Resultado);
			var res = JSON.parse(Resultado);
			if (res.estado==1){
				tabla.row("#row_"+idEliminar).remove().draw();
			}
			
		},
		error: function (data){
			Swal.fire("Ocurrió un error");
		}
	});
	cerrarse();
}

function leerJeopardy(){
	id=idActualizar;
	let idCrucigrama = $('#idActv').val();
	//alert (idJeop);
	$.ajax({
		url: "actionReadCrucigrama.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			palabra = $('#updateP').val(RJSON.palabra);
			descripcion  = $('#updateDesc').val(RJSON.descripcion);
		},
	});
}

function mostrarPregunta() {
	// body...
	id=idEliminar;
	let idCruci = $('#idActv').val();
	//alert(idJeop);
	$.ajax({
		url: "actionReadCrucigrama.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			document.getElementById("idPalabra").innerHTML = RJSON.palabra;
			//pregunta = $('#idpregunta').val(RJSON.pregunta);
		}
	});
}

function cerrarse(){
    $("#modal-danger").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}