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

function guardarTextQuiz()
{
	let id_historia = document.getElementById('idHistoria').value;
	let id_grupo = document.getElementById('idGrupo').value;
	let idActividad = $('#idActv').val();
	var nom_act = $('#nom_act').val();
	let contenido = $('#editorOne').wysiwyg().html();
	//alert("hola: "+ nom_act + " "+ contenido);
	if(nom_act == "" || contenido == ""){
		Swal.fire("Complete todos los campos");
	}else{
		$.ajax({
			url: 'actionAddNomQuiz.php',
			type: 'POST',
			data: {
				accion : "guardarQuiz",
				idActv : idActividad,
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

function addQuiz() {
	// body...
	//Variables
	let idQuiz = $('#idActv').val();
	pregunta = $('#pregunta1').val();
	inc_uno  = $('#incorrecta1').val();
	respuesta  = $('#respuesta').val();
	inc_dos  = $('#incorrecta2').val();
	inc_tres  = $('#incorrecta3').val();
	puntaje  = $('#puntaje').val();
	//Referencias
	var tabla = $('#datatable').DataTable();

	//alert(pregunta + " : " + inc_uno + " : " + respuesta + " : " + inc_dos + " : " + inc_tres + " : " + puntaje + " : " +idQuiz);

	if(pregunta == "" || inc_uno == "" || respuesta == "" || inc_dos == "" || inc_tres == "" || puntaje == ""){
		Swal.fire("Completa todos los campos"); 
	}else if(isNaN(puntaje)){
		Swal.fire("El campo puntaje solo permite números NO letras");
	}else{
		$.ajax({
			url: 'actionAddQuiz.php',
			type: 'POST',
			data: {pregunta:pregunta,
				inc1:inc_uno,
				respuesta:respuesta,
				inc2:inc_dos,
				inc3:inc_tres,
				puntaje:puntaje,
				idActv : idQuiz,
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
						inc_uno,
						respuesta,
						inc_dos,
						inc_tres,
						puntaje,
						botonActualizar,
						botonEliminar
						]).draw().node().id="row_"+id;
				}
				Swal.fire(resJSON.mensaje);
			},
			error: function (data) {
				// body...
				Swal.fire("Ocurrió un error");
			}

		});
	}
	preguntasAdd.reset();
}
function IdentificaActualizar(id) {
	// body...
	idActualizar=id;
	//alert(id);
	leerQuiz();
}
function IdentificaEliminar(id) {
	// body...
	idEliminar=id;	
	mostrarPregunta();
}

function updateQuiz() {
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
			url: 'actionUpdateQuiz.php',
			type: 'POST',
			data: {pregunta:pregunta,
				inc1:inc_uno,
				respuesta:respuesta,
				inc2:inc_dos,
				inc3:inc_tres,
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
					temp[1]=inc_uno;
					temp[2]=respuesta;
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
	preguntasUpId.reset();
}

function deleteQuiz() {
	// body...
	var tabla = $('#datatable').DataTable();

	$.ajax({
		url: "actionDeleteQuiz.php",
		type: "POST",
		data: {
			id:idEliminar,
			accion:'eliminar'},
		success: function(Resultado) {
			//alert(Resultado);
			var res=JSON.parse(Resultado);
			if (res.estado==1) {
				tabla.row("#row_"+idEliminar).remove().draw();
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


function leerQuiz(){
	id=idActualizar;
	let idQuiz = $('#idActv').val();
	//alert(idQuiz);
	//alert("hola");
	$.ajax({
		url: "actionReadQuiz.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);

			pregunta = $('#preguntaUp').val(RJSON.pregunta);
			inc_uno  = $('#incorrecta1Up').val(RJSON.inc_uno);
			respuesta  = $('#respuestaUp').val(RJSON.respuesta);
			inc_dos  = $('#incorrecta2Up').val(RJSON.inc_dos);
			inc_tres  = $('#incorrecta3Up').val(RJSON.inc_tres);
			puntaje  = $('#puntajeUp').val(RJSON.puntaje);
			
		},
	});
}

function mostrarPregunta() {
	// body...
	id=idEliminar;
	let idActv = $('#idActv').val();
	//alert(idJeop);
	$.ajax({
		url: "actionReadQuiz.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			document.getElementById("idpregunta").innerHTML = RJSON.pregunta;
			//pregunta = $('#idpregunta').val(RJSON.pregunta);
		}
	});
}

function cerrarse(){
    $("#modal-danger").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}