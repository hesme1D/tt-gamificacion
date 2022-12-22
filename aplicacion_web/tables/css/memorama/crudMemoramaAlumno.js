let totalImagenes=0;
let iconos = [];
let selecciones = [];
var aciertos =0;
var contador =1;
var puntajeActi = 0;
var puntajeTotal =0;
var num_intentos =0;
var intentos=1;
var row=0;
let renglones ="";
const MAX_INTENTOSD=24;
const MAX_INTENTOS_S=6;
const intentos_x = 4;
var porcentaje;

window.onload = function(){
    btn_puntaje();
    btn_modal();
    mostrarImagenes();
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

    if(totalImagenes==6){
        let percent = (num_intentos/MAX_INTENTOS_S)*100;
        porcentaje = parseInt(percent); 
        progressBar.style.width = porcentaje + '%';
        progresBarText.textContent = porcentaje + '%';
        
    }else if(totalImagenes==12){
        let percent = (num_intentos/MAX_INTENTOSD)*100;
        porcentaje = parseInt(percent); 
        progressBar.style.width = porcentaje + '%';
        progresBarText.textContent = porcentaje + '%';
    }else{
        let percent = (num_intentos/intentos_x)*100;
        porcentaje = parseInt(percent); 
        progressBar.style.width = porcentaje + '%';
        progresBarText.textContent = porcentaje + '%';
    }

    
}


function mostrarImagenes(){
    let idActv = $('#idActv').val();
    $.ajax({
        url: "../tables/css/memorama/actionMemorama.php",
        type: "POST",
        data: {
            idActv:idActv,
            accion:'mostrar'
        },
        success: function(Resultado){
            //alert(Resultado);
            var RJSON = JSON.parse(Resultado);
                row = RJSON.num_imagenes;
            //alert(row);
            RJSON.imagenes.forEach(imagen =>{
                iconos.push(imagen.imagen);
                totalImagenes++;
            });
            generarTablero();
        },
    });
}

function generarTablero() {
    //cargarIconos()
    //alert(aciertos);
    selecciones = [];
    let tablero = document.getElementById("tablero");
    let tarjetas = [];

    for (let i = 0; i < totalImagenes*2; i++) {
        tarjetas.push(`

        <div class="area-tarjeta" onclick="seleccionarTarjeta(${i}), mostrarBarra();">
            <div class="tarjeta" id="tarjeta${i}">
                <div class="cara back" id="trasera${i}">
                    
                <img src="${iconos[0]}" class="imagen_atras">
                   
                </div>
                <div class="cara front">
                    <img class="imagen_frente" src="../tables/css/memorama/image/logo-ipn.png">
                </div>
            </div>
        </div>        
        `);
        if (i % 2 == 1) {
            iconos.splice(0, 1);
        }
    }
    tarjetas.sort(() => Math.random() - 0.5);
    tablero.innerHTML = tarjetas.join(" ");
}

function seleccionarTarjeta(i) {
    let tarjeta = document.getElementById("tarjeta" + i);
    if (tarjeta.style.transform != "rotateY(180deg)") {
        tarjeta.style.transform = "rotateY(180deg)";
        selecciones.push(i);
    }
    if (selecciones.length == 2) {
        num_intentos+=intentos;
        //alert(num_intentos);
        deseleccionar(selecciones);
        selecciones = [];
        
        
    }
}

function deseleccionar(selecciones) {
    var puntajeT = $('#idActCr').val();
        puntajeActi =  parseInt(puntajeT);
    setTimeout(() => {
        let trasera1 = document.getElementById("trasera" + selecciones[0]);
        let trasera2 = document.getElementById("trasera" + selecciones[1]);
        if (trasera1.innerHTML != trasera2.innerHTML) {
            let tarjeta1 = document.getElementById("tarjeta" + selecciones[0]);
            let tarjeta2 = document.getElementById("tarjeta" + selecciones[1]);
            tarjeta1.style.transform = "rotateY(0deg)";
            tarjeta2.style.transform = "rotateY(0deg)";
        }else{
            trasera1.style.background = "plum";
            trasera2.style.background = "plum";
            aciertos +=contador;
            //alert(aciertos);
        }
    }, 1000);

    puntajeTotal = (aciertos*puntajeActi)/row;
    //alert(puntajeTotal);
    //alert(num_intentos+ "+" +MAX_INTENTOSD);
    if(row==12){//tablero de 12 pares
        if(num_intentos >= MAX_INTENTOSD){
            if(aciertos < row/2){
                swal.fire({
                        title: "Juego Terminado",
                        imageUrl: "../tables/images/juego_terminadoI.gif",
                        html: "Intentos: "+ num_intentos+"/"+MAX_INTENTOSD + "<br> <br> Aciertos: "+aciertos+ "/" + row+ "<br> <br> Puntaje: " + puntajeTotal,
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
                        html: "Intentos: "+ num_intentos+"/"+MAX_INTENTOSD + "<br> <br> Aciertos: "+aciertos+ "/" + row+ "<br> <br> Puntaje: " + puntajeTotal,
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
    }

    if(row==6){//tablero de 6 pares
        if(num_intentos >= MAX_INTENTOS_S){
            if(aciertos < row/2){
                swal.fire({
                        title: "Juego Terminado",
                        imageUrl: "../tables/images/juego_terminadoI.gif",
                        html: "Intentos: "+ num_intentos+"/"+MAX_INTENTOS_S + "<br> <br> Aciertos: "+aciertos+ "/" + row+ "<br> <br> Puntaje: " + puntajeTotal,
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
                        html: "Intentos: "+ num_intentos+"/"+MAX_INTENTOS_S + "<br> <br> Aciertos: "+aciertos+ "/" + row+ "<br> <br> Puntaje: " + puntajeTotal,
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
    }
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
                renglones=renglones+'<tr style="align-items:center; background-color: #20c997; "><td style="border-radius: 15px;"><h3 align="center" style="color: white;">'+nombre+' ................................ '+puntaje+'</h3></td></tr><tr><td width="10px" height="10px"></td></tr>';
                
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
                    //  texto = testTexto;
                }
        }// acaba el bucle for
    // escribe en el canvas la última lineaDeTexto
    
    ctx.fillText(testTexto, x, y);
}
