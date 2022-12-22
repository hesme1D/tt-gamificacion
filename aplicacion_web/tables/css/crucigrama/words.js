//Variables
let words=[];
//Funciones
function leerPalabra(){
	let palabras=[];
	let idCrucigrama = $('#idActv').val();
	$.ajax({
		url: "../tables/css/crucigrama/actionReadPalabra.php",
		type: "POST",
		data: {
			idActv:idCrucigrama,
			accion:'mostrar'
		},
		success: function(Resultado){
			RJSON = JSON.parse(Resultado);
			RJSON.palabras.forEach(palabra => {
				words.push(palabra.palabra);
				todasMisPalabras.push(palabra);
			});

			console.log(words);
		},
	});

	return palabras;
}
leerPalabra();