//VARIABLES
//var pregunta;
var inc_uno;
var respuesta;
var inc_dos;
var inc_tres;
var puntaje=0;
var puntajePregunta =0;
var puntajeActi = 0;
var puntajeTotal=0;
var total=0;
var ren=0;
var nuevoP=0;
let renglones=""; 	 
let puntosJuego = 0;
let n;

let posibles_respuestas;
var botones;	

let nombre; 
//let puntaje;

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
	btn_puntaje();	
	btn_modal();
	escogerPreguntaAleatoria();

};

function btn_modal(){
	$("#btn_H").modal("show");
	mostrarProblematica();
}

function btn_puntaje(){
	$("#btn_puntaje").modal("show");
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
			n=Math.floor(Math.random() * RJSON.length);
			pregunta=RJSON[n];
			//alert(RJSON.length);
			document.getElementById("quiz");
			document.getElementById("pregunta").innerHTML = pregunta.pregunta;
			document.getElementById("btn1").innerHTML = pregunta.inc_uno;
			document.getElementById("btn2").innerHTML = pregunta.respuesta;
			document.getElementById("btn3").innerHTML = pregunta.inc_dos;
			document.getElementById("btn4").innerHTML = pregunta.inc_tres;

			//puntaje =  pregunta.puntaje;

			desordenarRespuestas(pregunta);
		}
	});
}

//Función preguntas aleatorias.
function escogerPreguntaAleatoria() {

	var puntajeT = $('#idActCr').val();
		puntajeActi =  parseInt(puntajeT);
			//alert(puntajeR);

	
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
	    					//alert("Contenido de los renglones "+$("#renglones").val());
	    					
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
	puntosJuego = parseInt(pregunta.puntaje);
	total += puntosJuego;
	//alert(total);
	//alert("Hola Nuevo"+suspenderbtn);
	if(suspenderbtn){
		return;
	} else {
	suspenderbtn=true;
	if(posibles_respuestas[i] == pregunta.respuesta){
		preguntas_correctas++;
		puntaje =  parseInt(pregunta.puntaje);
		btn_c[i].style.background="lightgreen";
		puntajePregunta+=puntaje;	
		puntajeTotal = (puntajePregunta*puntajeActi)/total;
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
				renglones=renglones+'<tr style="align-items:center; background-color: #B86461;"><td style="border-radius: 15px;"><h3 align="center" style="color: white;">'+nombre+' ................................ '+puntaje+'</h3></td></tr><tr><td height="10px"></td></tr>';
				
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

var canvas = document.getElementById("problematica");
var ctx = canvas.getContext("2d");
let texto;
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
			texto= imagen.historia_part;
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
