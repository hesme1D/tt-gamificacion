var idEliminar 		=0;
var idActualizar 	=0;
var contador 		=3;

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
			Swal.fire(resJSON.mensaje);
			window.location.replace("../tables/nom_clase.php?idGrupo="+id_grupo);
		},
		error: function (data) {
			// body...
		}
	});
}


function addRetos(){
	//Referencias
	tabla = $('#datatable').DataTable();
	pregunta  = $('#pregunta').val();
	respuesta  = $('#respuesta').val();
	inc_uno  = $('#inc1').val();
	inc_dos  = $('#inc2').val();
	inc_tres  = $('#inc3').val();
	puntaje  = $('#puntaje').val();
	let id_Activ  = $('#idActv').val();
	var btn_retos = $('#btn_retos');
	var btn_retos1 = $('#btn_retos1');
	let filas = $('#filas').val();
	//alert("hola mundo" +pregunta+" " + respuesta + " " +inc_uno+" "+inc_dos+" "+inc_tres+" "+puntaje+ "" + id_Activ);
	if(pregunta == "" || respuesta == "" || inc_uno == "" || inc_dos == "" || inc_tres == "" || puntaje == ""){
		Swal.fire("Completa todos los campos"); 
	}else if(isNaN(puntaje)){
		Swal.fire("El campo puntaje solo permite números NO letras");
	}else{
		
		$.ajax({
			url: 'actionAddRetos.php',
			type: 'POST',
			data: { 
				pregunta:pregunta,
				respuesta:respuesta, 
				inc1:inc_uno, 
				inc2:inc_dos, 
				inc3:inc_tres,
				puntaje:puntaje,
				idActv : id_Activ,
				accion:'guardarRetos'},
			//dataType: 'json',
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
				if (resJSON.num_retos>=3){
					$('#btn_retos').attr('disabled', true);
				}

				if (resJSON.num_retos>=3){
					$('#btn_uno').attr('disabled', true);
				}
			},
			error: function (data) {
				// body...
				Swal.fire("Ocurrió un error");
			}

		});
}

retosId.reset();
//window.location.href("../tables/retos.php");

}
function IdentificaActualizar(id) {
	// body...
	idActualizar=id;
	//alert(id);	
	leerRetos();
}

function IdentificaEliminar(id) {
	// body...
	idEliminar=id;
	mostrarPregunta();
}

function updateRetos() {
	// body...
	//Variables
	let id_Activ = $('#idActv').val();
	pregunta = $('#update_pregunta').val();
	inc_uno  = $('#update_inc1').val();
	respuesta  = $('#update_respuesta').val();
	inc_dos  = $('#update_inc2').val();
	inc_tres  = $('#update_inc3').val();
	puntaje  = $('#updatePuntaje').val();
	//Referencias
	tabla = $('#datatable').DataTable();
	id= idActualizar;

	//alert(pregunta + inc_uno + respuesta + inc_dos+inc_tres+puntaje);

	if(pregunta == "" || inc_uno == "" || respuesta == "" || inc_dos == "" || inc_tres == "" || puntaje == ""){
		Swal.fire("Completa todos los campos"); 
	}else if(isNaN(puntaje)){
		Swal.fire("El campo puntaje solo permite números NO letras");
	}else{
		$.ajax({
			url: 'actionUpdateRetos.php',
			type: 'POST',
			data: {
				pregunta:pregunta,
				respuesta:respuesta, 
				inc1:inc_uno, 
				inc2:inc_dos, 
				inc3:inc_tres,
				puntaje:puntaje,
				idActv : id,
				accion:'actualizarRetos'},
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
					//window.location.redirect("../tables/quiz.php?idGrupo="+id_grupo+"&"+"idHistoria="+id_historia+"&"+"idActividad="+idActividad);
					//window.location.redirect("../tables/elegir_actividad.php?idGrupo="+id_grupo+"&"+"idHistoria="+id_historia);
				}
				Swal.fire(resJSON.mensaje);
			},
			error: function (data) {
				// body...
				Swal.fire("Ocurrió un error");
			}

		});
	}
	//retosId.reset();
}

function deleteRetos(){
	tabla = $('#datatable').DataTable();
	id_Activ =$('#idActv').val();
	var btn_retos = $('#btn_retos');
	id= idEliminar;
	//alert(id);
	$.ajax({
		url: "actionDeleteRetos.php",
		type: "POST",
		data: {
			id_Activ:id_Activ,
			id:idEliminar, 
			accion:'eliminar'},
		success: function(Resultado){
			//alert(Resultado);
			var res = JSON.parse(Resultado);
			if (res.estado==1){
				tabla.row("#row_"+idEliminar).remove().draw();
				if (res.num_retos<3){
					$('#btn_retos').attr('disabled', false);		
				}
				if (res.num_retos<3){
					$('#btn_uno').attr('disabled', false);		
				}

			}
			//alert(res.mensaje);
			//alert(res.num_retos);
			
		},
		error: function (data){
			Swal.fire("Ocurrió un error");
		}
	});
}

function leerRetos() {
	// body...
	id=idActualizar;
	let idRetos = $('#idActv').val();
	$.ajax({
		url: "actionReadRetos.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			pregunta = $('#update_pregunta').val(RJSON.pregunta);
			inc_uno  = $('#update_inc1').val(RJSON.inc_uno);
			respuesta  = $('#update_respuesta').val(RJSON.respuesta);
			inc_dos  = $('#update_inc2').val(RJSON.inc_dos);
			inc_tres  = $('#update_inc3').val(RJSON.inc_tres);
			puntaje  = $('#updatePuntaje').val(RJSON.puntaje);
		}
	});
}

function mostrarPregunta() {
	// body...
	id=idEliminar;
	let idRetos = $('#idActv').val();
	//alert("hola");
	$.ajax({
		url: "actionReadRetos.php",
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