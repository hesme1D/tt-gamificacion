var dado = new Dado();
var player = new Jugador();
let n;

//Eventos de click para cada Jugador
document.getElementById('btn_1').addEventListener('click',jugar1);

//Función Jugar
function jugar1()
{
	var id = "ficha1";
	var id2 = "r1";
	player.recibirResultado(dado.lanzar(),id,id2);
}

var posiciones=0;
var posicion; 
var j=0, i=0;
var contador =0;
let renglones;  

window.onload = function(){
  generarTablero();
  escogerPreguntaAleatoria();
};

	
function generarTablero(){
	var tablero = document.getElementById('tablero');

	renglones = '<table align="center" width="66%" id="tablero" background="../tables/images/tablero.png"> <tbody>';

	for (j=0; j< 10; j++) {
	  renglones = renglones +'<tr height="46.3px" align="center" >';
	  for (i=0; i<10; i++) {
	  	contador++;

	    renglones = renglones +'<td align="center" width="46.3px" id="casilla_'+contador+'"><input type="hidden" name="posicionJ" id="filaJ" value="'+j+'"><input type="hidden" name="posicionI" id="columnaI" value="'+i+'"></td>';
	  } 
	}
	renglones = renglones+'</tbody></table>';

	tablero.innerHTML = renglones;
}

/************************************************************************/
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

function leerPregunta(n) {

	let idActv = $('#idActv').val();
	$.ajax({
		url: '../tables/css/serpientesYescaleras/actionSerpientes.php',
		type: 'POST',
		data: {
			idActv:idActv,
			accion:'mostrar'
		},
		success: function (Resultado) {
			var RJSON = JSON.parse(Resultado);
			pregunta=RJSON[n];

			document.getElementById("pregunta").innerHTML = pregunta.pregunta;
			document.getElementById("btn1").innerHTML = pregunta.inc_uno;
			document.getElementById("btn2").innerHTML = pregunta.respuesta;
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
		alert(n);
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
				suspenderbtn=true;
				swal.fire({
					title: "Juego Terminado",
					}).then(function() {
    				window.location = "../tables/actividades.php";
				});
			}
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

	document.getElementById("btn1").innerHTML = posibles_respuestas[0]
	document.getElementById("btn2").innerHTML = posibles_respuestas[1];
	document.getElementById("btn3").innerHTML = posibles_respuestas[2];
	document.getElementById("btn4").innerHTML = posibles_respuestas[3];
}

let suspenderbtn = false;

function oprimir(i){
	if(suspenderbtn){
		return;
	} else {
	suspenderbtn=true;
	if(posibles_respuestas[i] == pregunta.respuesta){
		btn_c[i].style.background="lightgreen";			
		player.escalera();
	} else {
		btn_c[i].style.background="pink";
		
		player.serpiente();
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
  	}, 900

  	);
}

function reiniciar() {
  for (const btn of btn_c) {
    btn.style.background = "white";
    cerrarse();
  }
}

function cerrarse(){
  $("#btn_pregunta").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}

