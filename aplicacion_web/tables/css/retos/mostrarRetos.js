//VARIABLES
let posibles_respuestas;
let preguntas_aleatorias = true;
let mostrar_pantalla=true;
let reiniciar_puntos=true;
let npreguntas=[];
let preguntas_hechas=0;
let preguntas_correctas=0;
let pregunta;

let RJSON=[];

btn_C = [
	document.getElementById("btn1Aux"),
	document.getElementById("btn2Aux"),
	document.getElementById("btn3Aux"),
	document.getElementById("btn4Aux")
];

//FUNCIONES

window.onload = function() {
	// body...
	escogerPreguntaAleatoria();
}

function leerPregunta(n) {
	// body...
	let idRetos = $('#idActv').val();

	$.ajax({
		url: '../tables/css/retos/actionRespuestasRetos.php',
		type: 'POST',
		data: {
			idActv:idRetos,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			RJSON = JSON.parse(Resultado);
			pregunta=RJSON[n];

			document.getElementById("retos");
			document.getElementById("pregunta").innerHTML = pregunta.pregunta;
			document.getElementById("btn1").innerHTML = pregunta.respuesta;
			document.getElementById("btn2").innerHTML = pregunta.inc_uno;
			document.getElementById("btn3").innerHTML = pregunta.inc_dos;
			document.getElementById("btn4").innerHTML = pregunta.inc_tres;

			desordenarRespuestas(pregunta);
		}
	});
}

function escogerPreguntaAleatoria() {
	// body...
	let n;
	if (preguntas_aleatorias) {
		n=Math.floor(Math.random() * RJSON.length);
	}else{
		n=0;
	}

	while(npreguntas.includes(n)){
		n++;
		if (n>=RJSON.length) {
			n=0;
		}
		if (npreguntas.length==RJSON.length) {
			if (mostrar_pantalla) {
				swal.fire({
					title: "Juego Terminado",
					//text: "Puntuación "+preguntas_correctas+ "/" + preguntas_hechas
					}).then(function() {
    				//window.location = "../tables/actividades.php";
				});
			}
			//AQUÍ VA EL IF PARA LA PUNTUACIÓN
			if (reiniciar_puntos) {
				preguntas_correctas=0;
				preguntas_hechas=0;
			}
			npreguntas=[];
		}
	}
	npreguntas.push(n);
	preguntas_hechas++;
	leerPregunta(n);
}

function desordenarRespuestas() {
	// body...
	posibles_respuestas=[
		pregunta.respuesta,
		pregunta.inc_uno,
		pregunta.inc_dos,
		pregunta.inc_tres,
	];

	posibles_respuestas.sort(() => Math.random() - 0.5);

	document.getElementById("btn1").innerHTML = posibles_respuestas[0];
	document.getElementById("btn2").innerHTML = posibles_respuestas[1];
	document.getElementById("btn3").innerHTML = posibles_respuestas[2];
	document.getElementById("btn4").innerHTML = posibles_respuestas[3];

}

let suspenderbtn = false;

 function oprimir(i) {
 	// body...
 	if (suspenderbtn) {
 		return;
 	} else{
 		suspenderbtn=true;
 		if (posibles_respuestas[i]==pregunta.respuesta) {
 			preguntas_correctas++;
 			btn_C[i].style.background="lightgreen";
 		}else {
 			btn_C[i].style.background="pink";
 		}

 		for (let j=0; j<4; j++) {
 			if (posibles_respuestas[j]==pregunta.respuesta) {
 				btn_C[j].style.background="lightgreen";
 				break;
 			}
 		}
 	}

 	setTimeout(() => {
 		reiniciar();
 		suspenderbtn=false;
 	}, 1000);

 }

 function reiniciar() {
 	// body...
 	for (const btn of btn_C) {
 		btn.style.background="white";
 	}
 	escogerPreguntaAleatoria();
 }