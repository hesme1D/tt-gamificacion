var dado = new Dado();
var player = new Jugador();
let n;
var puntajePregunta =0;
var puntajeActi = 0;
var puntajeTotal=0;
var total=0;
var ren=0;
var nuevoP=0;
//let renglones = "";
let puntosJuego = 0;
let actividad;

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
	btn_modal();
	btn_puntaje();
  generarTablero();
  escogerPreguntaAleatoria();
};

function btn_modal(){
	$("#btn_H").modal("show");
	mostrarProblematica();
}

function btn_puntaje(){
	$("#btn_puntaje").modal("show");
}

	
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
		//alert(n);
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
	//puntaje de la actividad
	actividad = $('#puntajeAct').val();
	var con = parseInt(actividad);

	//puntaje total de las preguntas
	var puntajePre = $('#puntajeTot').val();
	var aux = parseInt(puntajePre);
	//alert(aux);

	if(suspenderbtn){
		return;
	} else {
	suspenderbtn=true;
	if(posibles_respuestas[i] == pregunta.respuesta){
		btn_c[i].style.background="lightgreen";			
		player.escalera();
		preguntas_correctas++;
		puntaje =  parseInt(pregunta.puntaje);
		puntajePregunta+=puntaje;
		var antes = aux - puntajePregunta;
		//alert(antes);
		puntajeTotal = (antes*actividad)/aux;
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
	//rankingActiv();
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
			let renglones ="";
			RJson.puntajes.forEach(({nombre,puntaje})=>{
				renglones=renglones+'<tr style="align-items:center; background-color: #804000;"><td style="border-radius: 15px;"><h3 align="center" style="color: white;">'+nombre+' ................................ '+puntaje+'</h3></td></tr><tr><td height="10px"></td></tr>';
				
			});
			Swal.fire({
				width: '800px',
				height: '2000%',
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

function generar(){// agregar if para el puntaje obtenido
	swal.fire({
				title: "Juego Terminado",
				imageUrl: "../tables/images/juego_terminadoI.gif",
				html: "Puntaje: " + puntajeTotal,
			  	confirmButtonColor: '#3085d6',
			  	confirmButtonText: 'Ver ranking'
				}).then((result) =>{
						rankingActiv();
    				if(result.isConfirmed){
    					mostrarRanking();
    				}
			});
}

var canvas = document.getElementById("problematica");
var ctx = canvas.getContext("2d");
let historia;
let altura = 17;
let padding = 20;
let w = canvas.width - 25*padding; 
let x = 300;
let y = 170;

function mostrarProblematica(){
	// body...
	let idHistoria = $('#idHistoria').val();
	let idActv = $('#idActv').val();
	
	$.ajax({
		url: 'actionNomAct.php',
		type: 'POST',
		data: {
			idActv:idActv,
			idHistoria:idHistoria,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			RJSON = JSON.parse(Resultado);
			imagen=RJSON;
			var img = new Image();
			var img2 =  new Image();
			img.src = imagen.imagen_paisaje;
			img2.src = imagen.imagen_personaje;
			let texto= imagen.historia_part;
			//alert(texto);
			img.onload = function(){
			  
			  //ctx.strokeStyle="black";
			  ctx.fillStyle= "white";
          	  ctx.font="bold 16px consolas";
			  ctx.drawImage(img,0, 0, 1000, 500);
			  ctx.drawImage(img2, 0, 320, 330, 200);
			  
			  //ctx.strokeText(texto,20, 300);
			  tamanioTexto(texto, x, y, w, altura);
			}

		}
	});	
}


function tamanioTexto(texto, x, y, maxWidth, altura){
	//alert(texto);
	texto = texto.replace(/<script[^>]>([\S\s]?)<\/script>/gmi, '');
	texto = texto.replace(/<\/?\w(?:[^"'>]|"[^"]"|'[^']')*>/gmi, '');
	texto = texto.replace('<div style="text-align: left;">', '');
	texto = texto.replace('</div>', '');

  

	let testTexto=" ";
    let palabrasRy = texto.split(" ");
    // inicia la variable var lineaDeTexto
    
    // un bucle for recorre todas las palabras
        for(let i = 0; i < palabrasRy.length; i++) {
	        testTexto = testTexto + palabrasRy[i] + " ";
	        // calcula la anchura del texto textWidth 
	        let textWidth = ctx.measureText(testTexto).width;
	        // si textWidth > maxWidth
	            if (textWidth > maxWidth  && i > 0) {
		            // escribe en el canvas la lineaDeTexto
		          
		            ctx.fillText(testTexto, x, y);
		            // inicia otra lineaDeTexto         
		            testTexto = "";
		            // incrementa el valor de la variable y 
		            //donde empieza la nueva lineaDeTexto
		            y += altura;
	            }else {// de lo contrario,  si textWidth <= maxWidth 
	            	//	texto = testTexto;
	            }
        }// acaba el bucle for
    // escribe en el canvas la última lineaDeTexto
    
    ctx.fillText(testTexto, x, y);
}