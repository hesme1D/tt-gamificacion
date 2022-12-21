let objJson;
function addGrupo(){
	var nom_grupo = $('#nom_grupo').val();
	var descripcion = $('#descripcion').val();
	if(nom_grupo == "" || descripcion == ""){
		Swal.fire("Los campos no pueden estar vacíos");
	}else{ 
	    $.ajax({
			url: 'actionAddNuevoGrupo.php',
			type: 'POST',
			data: {
				accion: "guardarGrupo",
				nom_grupo: nom_grupo,
				descripcion : descripcion
			},
			success: function(Resultado) {
				//alert(Resultado);
				objJson = JSON.parse(Resultado);
				window.location.href = "http://localhost/tt-gamificacion/aplicacion_web/tables/nom_clase.php?idGrupo="+objJson.id;
				Swal.fire(objJson.mensaje);
			},
			error: function (data) {
				// body...
			}
		});
	}
	formGrupo.reset();
}

