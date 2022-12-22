//VARIABLES
var puntaje=0;
var puntajePregunta =0;
var puntajeActi = 0;
var puntajeTotal=0;

let posibles_respuestas;
let preguntas_aleatorias = true;
let mostrar_pantalla=true;
let reiniciar_puntos=true;
let npreguntas=[];
let preguntas_hechas=0;
let preguntas_correctas=0;
let pregunta;
let puntosJuego;
let total=0;

let renglones = "";

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
	btn_modal();
	escogerPreguntaAleatoria();
	//mostrarRanking();
}
function btn_modal(){
	$("#btn_H").modal("show");
}

function mostrarBarra() {
    const progressBar = document.getElementById('progress');
    const progresBarText = document.getElementById('mostrar');
    let percent = (preguntas_hechas/RJSON.length)*100;
    var porcentaje = parseInt(percent); 
    progressBar.style.width = porcentaje + '%';
    progresBarText.textContent = porcentaje + '%';
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
	var puntajeT = $('#idActCr').val();
		puntajeActi =  parseInt(puntajeT);

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
				if(preguntas_correctas < preguntas_hechas/2){
					swal.fire({
						title: "Juego Terminado",
						imageUrl: "../tables/images/juego_terminadoI.gif",
						html: "Aciertos: "+preguntas_correctas+ "/" + preguntas_hechas+ "<br> <br> Puntaje: " + puntajeTotal,
					  	confirmButtonColor: '#3085d6',
					  	confirmButtonText: 'Ver ranking'
					}).then((result) =>{
						rankingActiv();
	    				if(result.isConfirmed){
	    					mostrarRanking();
	    				}
	    				
					});
				}else{
					swal.fire({
						title: "Juego Terminado",
						imageUrl: "../tables/images/juego_terminado.gif",
						html: "Aciertos: "+preguntas_correctas+ "/" + preguntas_hechas+ "<br> <br> Puntaje: " + puntajeTotal,
					  	confirmButtonColor: '#3085d6',
					  	confirmButtonText: 'Ver ranking'
					}).then((result) =>{
						rankingActiv();
	    				if(result.isConfirmed){
	    					mostrarRanking();
	    					
	    				}
	    				
					});
				}	
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

 	puntosJuego = parseInt(pregunta.puntaje);
	total += puntosJuego;
 	// body...
 	if (suspenderbtn) {
 		return;
 	} else{
 		suspenderbtn=true;
 		if (posibles_respuestas[i]==pregunta.respuesta) {
 			preguntas_correctas++;
			puntaje =  parseInt(pregunta.puntaje);
			btn_C[i].style.background="lightgreen";
			puntajePregunta+=puntaje;

			puntajeTotal = (puntajePregunta*puntajeActi)/total;
			//alert(puntajeTotal);
			//alert(puntajePregunta);
		} else {
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

function rankingActiv(){
 	puntajeTotal;
 	let idActv = $('#idActv').val();
 	let idUsuario = $('#idUsuario').val();

 	$.ajax({
		url: 'actionAddRankingAct.php',
		type: 'POST',
		data: {
			accion : "guardar",
			idActv : idActv,
			puntajeTotal : puntajeTotal,
			idUsuario : idUsuario
		},
		success: function(Resultado) {
			// body...
			//alert(Resultado);
			var resJSON = JSON.parse(Resultado);
			//alert(resJSON.mensaje);
			//window.location.replace("../tables/quiz.php?idGrupo="+id_grupo+"&"+"idHistoria="+id_historia+"&"+"idActividad="+idActividad);
		},
		error: function (data) {
			// body...
		}
	});
}

function mostrarRanking(){
	let idActv = $('#idActv').val();
	$.ajax({
		url: 'actionReadPuntaje.php',
		type: 'POST',
		data: {
			accion : "mostrar",
			idActv : idActv
		},
		success: function(Resultado) {
			//alert(Resultado);
			var RJson = JSON.parse(Resultado);
			
			RJson.puntajes.forEach(({nombre,puntaje})=>{
				renglones=renglones+'<tr style="align-items:center; background-color: #dddc63; "><td style="border-radius: 15px;"><h3 align="center">'+nombre+' ................................ '+puntaje+'</h3></td></tr><tr><td width="10px" height="10px"></td></tr>';
			});
			Swal.fire({
				width: '800px',
				height: '1500%',
		      	title:"Ranking",
		      	html: '<table width="100%" style="align-items:center; border-radius: 10px;" id="tablaPodium">'+renglones+'</table>'
			      	
		    }).then(function(){
				window.location.replace("../tables/actividades.php");
			});
		},
		error: function (data) {
			// body...
		}
	});
	//alert(renglones);
	//console.log("Antes de regresar "+renglones);
	return renglones;
}