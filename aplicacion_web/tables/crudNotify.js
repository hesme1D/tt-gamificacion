window.onload = function(){
	notify();
	grupoN();
};

var n;
let mensaje = ["¿Vas a dejar que tus compañeros obtengan mayor puntaje que tú... ?, Continúa realizando tus actividades para avanzar en el ranking ", "Tus actividades te esperan" , "NO decistas, este podría ser una día bueno", "Tus actividades de hoy son una inversión para el ranking"];
function notify(){
	n = Math.floor(Math.random() * mensaje.length); 
	new	PNotify({
		title: 'Recordatorio: ',
	    text: '<h6>'+mensaje[n]+'</h6>',
	    type: 'info',
	    styling: 'bootstrap3'
	});
}

function grupoN(){
	var idUsuario = $('#idUsuario').val();
	$.ajax({
		url: "../tables/actionReadNotify.php",
		type: "POST",
		data: {
			idUsuario:idUsuario,
			accion:'mostrar'
		},
		success: function(Resultado){
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
			
			RJSON.forEach(({nom_noti,mensaje})=>{
				new PNotify({
					title: 'Notificacion',
				    text: '<div><h6>'+nom_noti+' '+mensaje+'</h6></div>',
				    styling: 'bootstrap3',
				    addclass: 'dark'
				});
				
			});
		},
		error: function (data) {
			// body...
		}
	});
	
}
