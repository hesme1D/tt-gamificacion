function selectTipo(){
	var idTipo   = $('#idTipo').val();
	//alert('Hola Mundo, soy: '+idTipo );
	//console.log('hola mundo' + idTipo);
	
	$.ajax({
		url: 'actionSelectTipo.php',
		type: 'POST',
		data: {
			accion: "guardar",
			idGrupo: idTipo	
		},
		success: function(Resultado) {
			//alert(Resultado);
		},
		error: function (data) {

		}
	});
}