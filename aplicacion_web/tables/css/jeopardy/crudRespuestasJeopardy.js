//VARIABLES
let idenId=0;
var pregunta;
var inc_uno;
var respuesta;
var inc_dos;
var inc_tres;
var puntaje;
var id;

let posibles_respuestas;
var botones;

let preguntas_aleatorias=true;
let mostrar_pantalla=true;
//let reiniciar_puntos=true;
//let npreguntas=[];
//let preguntas_hechas=0;
let preguntas_correctas=0;


btn_c = [
	document.getElementById("btn1Aux"),
	document.getElementById("btn2Aux"),
	document.getElementById("btn3Aux"),
	document.getElementById("btn4Aux")
];

function identificaID(id){
	idenId = id;
	leerPregunta();
}

function leerPregunta() {
	id=idenId;
	//alert(id);
	let idJeop = $('#idActv').val();
	//alert (idJeop);
	$.ajax({
		url: "../tables/css/jeopardy/actionRespuestasJeopardy.php",
		type: "POST",
		data: {
			idActv:id,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			//alert(RJSON.nom_cat);
			pregunta=RJSON;
			document.getElementById("categoria").innerHTML = RJSON.nom_cat;
			document.getElementById("pregunta").innerHTML = RJSON.pregunta;
			document.getElementById("btn1").innerHTML = RJSON.respuesta;
			document.getElementById("btn2").innerHTML = RJSON.inc_uno;
			document.getElementById("btn3").innerHTML = RJSON.inc_dos;
			document.getElementById("btn4").innerHTML = RJSON.inc_tres;
			desordenarRespuestas(pregunta);
		},
	});
}

function desordenarRespuestas(pregunta) {
	// body...
	posibles_respuestas=[
		pregunta.inc_uno,
		pregunta.respuesta,
		pregunta.inc_dos,
		pregunta.inc_tres
	];

	posibles_respuestas.sort(() => Math.random() - 0.5);
	//alert(posibles_respuestas);

	document.getElementById("btn1").innerHTML = posibles_respuestas[0];
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
		preguntas_correctas++;
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
    cerrarse();
  }
  //alert('btn_puntaje_'+idenId);
  document.getElementById('btn_puntaje_'+idenId).disabled = true; //intento 1
  //identificaID().disable; //intento 2 
}

function cerrarse(){
  $("#modal-lg").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
}