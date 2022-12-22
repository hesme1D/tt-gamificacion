//VARIABLES
//var pregunta;
var inc_uno;
var respuesta;
var inc_dos;
var inc_tres;
var puntaje;

let posibles_respuestas;
var botones;

let preguntas_aleatorias=true;
let mostrar_pantalla=true;
let reiniciar_puntos=true;
let npreguntas=[];
let preguntas_hechas=0;
let preguntas_correctas=0;
let pregunta;

let RJSON=[];

btn_c = [
	document.getElementById("btn1Aux"),
	document.getElementById("btn2Aux"),
	document.getElementById("btn3Aux"),
	document.getElementById("btn4Aux")
];

//FUNCIONES
window.onload = function(){
	//$("encabezado").css( {font-family: 'fantasy', font-size: 'x-large', color: '#854846'} );
	//leerPregunta();
	escogerPreguntaAleatoria();
};

function leerPregunta(n) {
	// body...
	let idQuiz = $('#idActv').val();
	//alert(idQuiz);
	$.ajax({
		url: '../tables/css/quiz/actionRespuestasQuiz.php',
		type: 'POST',
		data: {
			idActv:idQuiz,
			accion:'mostrar'
		},
		success: function (Resultado) {
			// body...
			//alert(Resultado);
			RJSON = JSON.parse(Resultado);
			pregunta=RJSON[n];
			//alert(RJSON.length);
			document.getElementById("quiz");
			document.getElementById("pregunta").innerHTML = pregunta.pregunta;
			document.getElementById("btn1").innerHTML = pregunta.inc_uno;
			document.getElementById("btn2").innerHTML = pregunta.respuesta;
			document.getElementById("btn3").innerHTML = pregunta.inc_dos;
			document.getElementById("btn4").innerHTML = pregunta.inc_tres;

			desordenarRespuestas(pregunta);
		}
	});
}

//Función preguntas aleatorias.
function escogerPreguntaAleatoria() {
	// body...
	let n;
	if (preguntas_aleatorias) {
		//alert("Holaaa");
		n=Math.floor(Math.random() * RJSON.length);
		//n=(Math.random()* 2.5);
		//alert(n);
	}else{
		//alert("Hola 2");
		n=0;
	}

	while(npreguntas.includes(n)){
		//alert("Holaa");
		n++;
		if (n>=RJSON.length) {
			n=0;
		}
		if (npreguntas.length==RJSON.length) {
			//Aquí el juego se reinicia.
			//alert("Hola");
			if (mostrar_pantalla) {
				suspenderbtn=true;
				//alert("Juego Terminado");
				swal.fire({
					title: "Juego Terminado",
					//text: "Puntuación "+preguntas_correctas+ "/" + preguntas_hechas
					}).then(function() {
    				window.location = "../tables/actividades.php";
				});
			}
			//Aquí va if para los puntos
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

function desordenarRespuestas(pregunta) {
	// body...
	posibles_respuestas=[
		pregunta.inc_uno,
		pregunta.respuesta,
		pregunta.inc_dos,
		pregunta.inc_tres,
	];

	posibles_respuestas.sort(() => Math.random() - 0.5);
	//alert(posibles_respuestas);

	document.getElementById("btn1").innerHTML = posibles_respuestas[0]
	document.getElementById("btn2").innerHTML = posibles_respuestas[1];
	document.getElementById("btn3").innerHTML = posibles_respuestas[2];
	document.getElementById("btn4").innerHTML = posibles_respuestas[3];
}

let suspenderbtn = false;

function oprimir(i){


	//alert("Hola Nuevo"+suspenderbtn);
	if(suspenderbtn){
		return;
	} else {
	suspenderbtn=true;
	if(posibles_respuestas[i] == pregunta.respuesta){
		//preguntas_correctas++;
		btn_c[i].style.background="lightgreen";
	} else {
		btn_c[i].style.background="pink";
	}

	for (let j =0; j<4; j++) {
		if (posibles_respuestas[j] == pregunta.respuesta) {
			btn_c[j].style.background="lightgreen";
			break;
		}
	}
}
	setTimeout(() => {
    	reiniciar();
    	suspenderbtn = false;
  	}, 1000

  	);
}

function reiniciar() {
  for (const btn of btn_c) {
    btn.style.background = "white";
  }
  escogerPreguntaAleatoria();
}