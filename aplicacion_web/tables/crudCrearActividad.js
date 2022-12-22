function crearActv() {
	// body...
	let idActv=$('#idActv').val();
	let idGrupo=$('#idGrupo').val();
	var puntaje=$('#puntaje').val();
	var premio=$('#heard').val();
	var nivel = $('#nivel').val();
	var fecha=$('#entrega').val();
	//var alumnos=$('#alumnos').val();
	/*var valores=Array.prototype.slice.call(document.querySelectorAll('#alumnos'),0).map(function(v,i,a){
		return v.value;
	});*/
//alert(idGrupo);
	if (puntaje == "" || nivel == "" || fecha == "") {
		Swal.fire('Debe llenar todos los campos');
		//alert("Debe llenar todos los campos");
	}else if(isNaN(puntaje)){
		Swal.fire('El campo puntaje solo permite números NO letras');
		//alert("El campo puntaje solo permite números NO letras");
	}else{
		$.ajax({
			url: 'actionCrearActividad.php',
			type: 'POST',
			data: {puntaje:puntaje,
				premio:premio,
				entrega:fecha,
				idGrupo:idGrupo,
				nivel:nivel,
				idActv:idActv,
				accion:'crear'},
			success: function(Resultado) {
				// body...
				//alert(Resultado);
				var resJSON = JSON.parse(Resultado);
				if(resJSON.estado==1){
					Swal.fire(resJSON.mensaje); 
					//alert(resJSON.mensaje);
					window.location.replace("index.php");
				}else{
					Swal.fire("Esta activiada ya fue creada");
					//alert("Esta activiada ya fue creada");
					window.location.replace("index.php");
				}
			},
			error: function(data) {
				Swal.fire("Ocurrió un error");
				//alert("Ocurrió un error");
			}
		});
	}
}