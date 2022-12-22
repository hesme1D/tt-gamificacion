var objJson;
let contenido;
let idGrupo;
let idPersonaje;
let idPaisaje;
let imagen;
//let contenido; 

window.onload = function(){
	mostrarProblematica();
};

function Guardar() //guardar texto
{	
	
	contenido = $('#editorOne').wysiwyg().html();
	idGrupo   = $('#idGrupo').val();
	//cons = document.querySelectorAll('input[name="size"]');
	
	idPaisaje   =  $('input[name="idPaisaje"]:checked').val();
	idPersonaje =  $('input[name="idPersonaje"]:checked').val();
	//alert("paisaje = "+idPaisaje);
	//alert("Personaje = " +idPersonaje);
	if(contenido == ""){
		Swal.fire("La historia no puede quedar vacía");
	}else if(idPersonaje == "" || idPaisaje == ""){
		Swal.fire("Por favor elige un Personaje y/o paisaje");
	}else{
    $.ajax({
		url: 'actionAddDefinirHistoria.php',
		type: 'POST',
		data: {
			accion: "guardar",
			idGrupo: idGrupo,
			contenido : contenido,
			idPersonaje : idPersonaje,
			idPaisaje : idPaisaje	
		},
		success: function(Resultado) {
			//alert(Resultado);
			objJson = JSON.parse(Resultado);
			Swal.fire(objJson.mensaje);
			window.location.href = "http://localhost/tt-gamificacion/aplicacion_web/tables/elegir_actividad.php?idHistoria="+objJson.id+"&"+"idGrupo="+idGrupo;

		},
		error: function (data) {
			// body...
		}
	});
	}
}

var canvas = document.getElementById("problematica");
var ctx = canvas.getContext("2d");
let texto;
let altura = 17;
let padding = 20;
let w = canvas.width - 25*padding; 
let x = 300;
let y = 170;

function mostrarProblematica(){
	// body...
	let idGrupo = $('#idGrupo').val();
	
	$.ajax({
		url: 'actionReadImagen.php',
		type: 'POST',
		data: {
			idGrupo:idGrupo,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			RJSON = JSON.parse(Resultado);
			imagen=RJSON;
			var img = new Image();
			var img2 =  new Image();
			//var img3 =  new Image();
			texto= imagen.historia; 
			//texto.style.color="black";
			img.src = imagen.imagen_paisaje;
			img2.src = imagen.imagen_personaje;

				
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
    // crea el array de las palabras del texto
    texto = texto.replace(/<script[^>]>([\S\s]?)<\/script>/gmi, '');
	texto = texto.replace(/<\/?\w(?:[^"'>]|"[^"]"|'[^']')*>/gmi, '');
	texto = texto.replace('<div style="text-align: left;">', '');
    texto = texto.replace('<font size="3">', '');
    texto = texto.replace('<ul>', '');
    texto = texto.replace('<li>', '');
    texto = texto.replace('<b>', '');
    texto = texto.replace('<i>', '');
    texto = texto.replace('<blockquote style="text-align: center; margin: 0px 0px 0px 40px; border: none; padding: 0px;">', '');
    texto = texto.replace('<strike>', '');
    texto = texto.replace('<font size="1">', '');
    texto = texto.replace('<div style="text-align: justify;">', '');
    texto = texto.replace('<blockquote style="text-align: center; margin: 0px 0px 0px 40px; border: none; padding: 0px;">', '');
    texto = texto.replace('<div style="text-align: center;">', '');
    texto = texto.replace('<font size="2">', '');
    texto = texto.replace('<ol>', '');
			



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
