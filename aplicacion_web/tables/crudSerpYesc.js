var idEliminar 		=0;
var idActualizar 	=0;

var id;
var tabla;
var pregunta;
var respuesta;
var inc_uno;
var inc_dos;
var inc_tres;
var puntaje;

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

function guardarTextSerpYesc()
{	
	let id_historia = document.getElementById('idHistoria').value;
	let id_grupo = document.getElementById('idGrupo').value;
	let id_tipo=document.getElementById('idTipo').value;
	var idActiv = $('#idActv').val();
	var nom_act = $('#nom_act').val();
	let contenido = $('#editorOne').wysiwyg().html();
	//alert("hola: "+ nom_act +" "+ contenido); 
   	if(nom_act == "" || contenido =="") {
   		Swal.fire("Los campos no pueden quedar vacíos"); 
   	}else{
   		$.ajax({
			url: 'actionAddSerpYesc.php',
			type: 'POST',
			data: {
				accion : "guardarSerpientes",
				idActv : idActiv,
				nom_act : nom_act,
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

function agregarPregunta(){
	let id_SP = $('#idActv').val();
	pregunta = $('#addPregunta').val();
	inc_uno  = $('#inc_uno').val();
	respuesta  = $('#respuesta').val();
	inc_dos  = $('#inc_dos').val();
	inc_tres  = $('#inc_tres').val();
	puntaje = $('#puntaje').val();
	var tabla = $('#datatable').DataTable();
	//alert(pregunta+inc_uno+respuesta+inc_dos+inc_tres);
	if(pregunta == "" || inc_uno == "" || respuesta == "" || inc_dos == "" || inc_tres == "" || puntaje == ""){
		Swal.fire("Completa todos los campos"); 
	}else if(isNaN(puntaje)){
		Swal.fire("El campo puntaje solo permite números NO letras"); 
	}else{
		$.ajax({
			url: 'actionAddPreguntasSP.php',
			type: 'POST',
			data: {
				pregunta:pregunta,
				respuesta:respuesta,
				inc_uno:inc_uno,
				inc_dos:inc_dos,
				inc_tres:inc_tres,
				puntaje : puntaje,
				idActv : id_SP,
				accion:'agregar'},
			success: function(Resultado) {
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					id=resJSON.id;
					var botonActualizar = '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('+id+')"><i class="fa fa-edit"></i></button></td>';
					var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
					tabla.row.add([
						pregunta,
						respuesta,
						inc_uno,
						inc_dos,
						inc_tres,
						puntaje,
						botonActualizar,
						botonEliminar
						]).draw().node().id="row_"+id;
				}
				Swal.fire(resJSON.mensaje);
				if (resJSON.num_preguntas>=10){
					$('#btn_serp').attr('disabled', true);
				}

				if (resJSON.num_preguntas>=10){
					$('#btn_serpYe').attr('disabled', true);
				}
			},
			error: function (data) {
				// body...
				Swal.fire("Ocurrió un error");
			}

		});
	}
	preguntas.reset();
}
function IdentificaActualizar(id) {
	// body...
	idActualizar=id;
	//alert(id);
	leerSerpYesc();
}
function IdentificaEliminar(id) {
	// body...
	idEliminar=id;	
	mostrarPregunta();
}

function updateSerpYesc() {
	// body...
	//Variables
	let idQuiz = $('#idActv').val();
	pregunta = $('#preguntaUp').val();
	inc_uno  = $('#incorrecta1Up').val();
	respuesta  = $('#respuestaUp').val();
	inc_dos  = $('#incorrecta2Up').val();
	inc_tres  = $('#incorrecta3Up').val();
	puntaje  = $('#puntajeUp').val();
	//Referencias
	var tabla = $('#datatable').DataTable();
	id=idActualizar;
	//alert(pregunta+inc_uno+respuesta+inc_dos+inc_tres+puntaje+idActualizar);

	if(pregunta == "" || inc_uno == "" || respuesta == "" || inc_dos == "" || inc_tres == "" || puntaje == ""){
		Swal.fire("Completa todos los campos"); 
	}else if(isNaN(puntaje)){
		Swal.fire("El campo puntaje solo permite números NO letras");
	}else{
		$.ajax({
			url: 'actionUpdateSerpYesc.php',
			type: 'POST',
			data: {pregunta:pregunta,
				inc_uno:inc_uno,
				respuesta:respuesta,
				inc_dos:inc_dos,
				inc_tres:inc_tres,
				puntaje:puntaje,
				idActv : id,
				accion:'actualizar'},
			success: function(Resultado) {
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if (resJSON.estado==1) {
					//id=resJSON.id;
					//var botonActualizar = '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-success" onclick="IdentificaActualizar('+id+')"><i class="fa fa-edit"></i></button></td>';
					//var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
					var temp = tabla.row('#row_'+id).data();
					temp[0]=pregunta;
					temp[1]=respuesta;
					temp[2]=inc_uno;
					temp[3]=inc_dos;
					temp[4]=inc_tres;
					temp[5]=puntaje;

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
	//preguntasUpId.reset();
}

function deleteSerpYesc() {
	// body...
	var tabla = $('#datatable').DataTable();
	id_Activ = $('#idActv').val();
	id= idEliminar;
	$.ajax({
		url: "actionDeleteSerpientes.php",
		type: "POST",
		data: {
			id:idEliminar,
			id_Activ:id_Activ,
			accion:'eliminar'
		},
		success: function(Resultado) {
			//alert(Resultado);
			var res=JSON.parse(Resultado);
			if (res.estado==1) {
				tabla.row("#row_"+idEliminar).remove().draw();
				if (res.num_retos<10){
					$('#btn_serp').attr('disabled', false);		
				}
			}
			//alert(res.mensaje);
		},
		error: function (data) {
			// body...
			Swal.fire("Ocurrió un error");
		}
	});
	cerrarse();
}

function leerSerpYesc(){
	id=idActualizar;
	let idQuiz = $('#idActv').val();
	//alert(idQuiz);
	//alert("hola");
	$.ajax({
		url: "actionReadSerpientes.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			pregunta = $('#preguntaUp').val(RJSON.pregunta);
			respuesta  = $('#respuestaUp').val(RJSON.respuesta);
			inc_uno  = $('#incorrecta1Up').val(RJSON.inc_uno);
			inc_dos  = $('#incorrecta2Up').val(RJSON.inc_dos);
			inc_tres  = $('#incorrecta3Up').val(RJSON.inc_tres);
			puntaje  = $('#puntajeUp').val(RJSON.puntaje);
			
		},
	});
}

function mostrarPregunta() {
	// body...
	id=idEliminar;
	let idJeop = $('#idActv').val();
	//alert(idJeop);
	$.ajax({
		url: "actionReadSerpientes.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			document.getElementById("idPregunta").innerHTML = RJSON.pregunta;
			//pregunta = $('#idpregunta').val(RJSON.pregunta);
		}
	});
}

function cerrarse(){
    $("#modal-danger").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}