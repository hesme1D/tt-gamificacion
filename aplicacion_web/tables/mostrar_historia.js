var canvas = document.getElementById("problematica");
var ctx = canvas.getContext("2d");
let texto;
let altura = 17;
let padding = 20;
let w = canvas.width - 25*padding; 
let x = 300;
let y = 170;

window.onload = function(){
	mostrarProblematica();
	deshabilitar();
};

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
    
    texto = texto.replace('<div style="text-align: left;">', '');
	texto = texto.replace(/<script[^>]>([\S\s]?)<\/script>/gmi, '');
	texto = texto.replace(/<\/?\w(?:[^"'>]|"[^"]"|'[^']')*>/gmi, '');
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

function deshabilitar(){
	$("#btn_H").click(function(){ //le decimos cuando hagas click ejecute una funccion anonima

	  $(this).hide(); //y que oculte este elemento clickeado

	 $(this).css("visivility","0"); //o si quieres darle simplemente una visivilidad 0 seria asi
	})
}