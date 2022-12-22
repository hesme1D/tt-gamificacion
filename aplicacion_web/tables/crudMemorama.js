let imagenD;

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

function guardarText()
{	
	let id_historia = document.getElementById('idHistoria').value;
	let id_grupo = document.getElementById('idGrupo').value;
	let id_tipo=document.getElementById('idTipo').value;
	var idActiv = $('#idActv').val();
	var nom_act = $('#nom_act').val();
	let contenido = $('#editorOne').wysiwyg().html();

	//alert("hola: "+nom_act+" " +contenido); 
	if(nom_act == "" || contenido =="") {
		Swal.fire("Los campos no pueden quedar vacíos"); 
   	}else{
	    $.ajax({
			url: 'actionAddMemorama.php',
			type: 'POST',
			data: {

				accion : 'guardarMemorama',
				idActv : idActiv, 
				nom_act : nom_act,
				contenido : contenido
			},
			success: function(Resultado) {
				// body...
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				//alert("../tables/memorama.php?idGrupo="+id_grupo+"&idHistoria="+id_historia+"&idActividad="+idActiv);
				Swal.fire(resJSON.mensaje);
				
				window.location.replace("../tables/nom_clase.php?idGrupo="+id_grupo);
				
			},
			error: function (data) {
				// body...
			}
		});
	}
}

function guardarImagen(){
	let idActv = $('#idActv').val();
	var seleccionImagen = $('#seleccionImagen').val();
	let id_grupo = document.getElementById('idGrupo').value;
	let id_historia = document.getElementById('idHistoria').value;
	var div = $('#btn_imagen');
	let id_tipo=document.getElementById('idTipo').value;
	////////////////////////////
	var formData = new FormData();
    var files = $('#seleccionImagen')[0].files[0];
    formData.append('seleccionImagen',files);
    formData.append('idActv',idActv);
    formData.append('accion','guardar');



	///////////////////////////
	//alert(seleccionImagen);
	$.ajax({
		url: 'actionAddImagesMemorama.php',
		type: 'POST',
		data:formData,
		contentType: false,
        processData: false,
		success: function(Resultado){
			//alert(Resultado);
			var resJSON = JSON.parse(Resultado);


			if(resJSON == 1){
				id=resJSON.id;
				var botonEliminar='<button type="button" class="btn" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar(<?php echo $muestra['+id+']?>)" background="black;" ></button>';
			}
			Swal.fire(resJSON.mensaje);
			window.location.replace("../tables/memorama.php?idGrupo="+id_grupo+"&idHistoria="+id_historia+"&tipo="+id_tipo+"&idActividad="+idActv);

			if (resJSON.num_imagen>=12){
				//alert("No puedes agregar más imágenes");
				$('#guardar').attr('disabled', true);
			}

				
		}, 
		error: function(data){

		}
	});
	//mostrar();
}

var idEliminar=0;

function IdentificaEliminar(id){
	idEliminar=id;
}

function deleteImage(){
	let idActv = $('#idActv').val();
	let id_grupo = document.getElementById('idGrupo').value;
	let id_historia = document.getElementById('idHistoria').value;
	let id_tipo=document.getElementById('idTipo').value;
	var id= idEliminar;
	var div = $('#btn_imagen');
	$.ajax({
		url: "actionDeleteImage.php",
		type: "POST",
		data: {
			id:idEliminar, 
			accion:'eliminar'},
		success: function(Resultado){
			//alert(Resultado);
			var res = JSON.parse(Resultado);
			window.location.replace("../tables/memorama.php?idGrupo="+id_grupo+"&idHistoria="+id_historia+"&tipo="+id_tipo+"&idActividad="+idActv);
		},
		error: function (data){
			Swal.fire("Ocurrió un error");
		}
	});
	cerrarse();
	//mostrar();
}

function cerrarse(){
	$("#modal-danger").modal('hide');//ocultamos el modal
	$('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
	$('.modal-backdrop').remove();//eliminamos el backdrop del modal
}