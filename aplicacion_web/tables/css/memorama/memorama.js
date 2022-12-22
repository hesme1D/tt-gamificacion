let totalImagenes=0;
let iconos = [];
let selecciones = [];

window.onload = function(){
    mostrarImagenes();
};

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
            var row = RJSON.num_imagenes;
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
    selecciones = [];
    let tablero = document.getElementById("tablero");
    let tarjetas = [];
    for (let i = 0; i < totalImagenes*2; i++) {
        tarjetas.push(`
        <div class="area-tarjeta" onclick="seleccionarTarjeta(${i})">
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
        deseleccionar(selecciones);
        selecciones = [];
    }
}

function deseleccionar(selecciones) {
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
        }
    }, 1000);
}