var idEliminar 		=0;
//var idActualizar 	=0;
//var idLeer 			=0:
function buscaPalabra() {
	// body...
	//Variables
	var palabraBusqueda;
	//Referencias
	palabraBusqueda = document.getElementById('busqueda').value;
	//Acciones
	//alert("Buscas la palabra: "+palabraBusqueda);
	//Comunicarnos con el servidor
	if(palabraBusqueda == ""){
		Swal.fire("Ingrese el nombre del alumno"); 
	} else {
	$.ajax({
		url: 'actionBusqueda.php',
		type: 'POST',
		data: {palabra: palabraBusqueda},
		success: function(Resultado) {
			// body...
			//alert(Resultado);
			var RJson = JSON.parse(Resultado);
			
			RJson.forEach(({id,nombre,apaterno,amaterno})=>{
				$("#tabla1 > tbody:last-child").append('<tr><td width="85%"><h5 style="color: black;">'+id+' '+nombre+' '+apaterno+' '+amaterno+'</td><td align="center" width="15%"><button type="submit" class="btn btn-outline-inverse"><i class="fa fa-plus" id="addAlumno" onclick="addAlumno('+id+');"></i></button></td></tr>');
			});

		},
		error: function (data) {
			// body...
			Swal.fire("Usuario no encontrado"); 
		}
	});
	}
}

function IdentificaEliminar(id) {
	// body...
	idEliminar=id;
	//alert(id);
	deleteUser()
}

function addAlumno(id){
	//alert("Se debe agregar el alumno: "+id);
	//alert(id);
	let idGrupo = $('#idGrupo').val();
	$.ajax({
		url: 'actionBusquedaAlumnoID.php',
		type: 'POST',
		data: {addAlumno: id, idGrupo:idGrupo, accion:'agregar'},
		success: function(Resultado) {
			// body...
			//alert(Resultado);
			var RJson = JSON.parse(Resultado);
			//alert(RJson.id);
			if (RJson.estado==1) {
				id=RJson.id;
				var tabla = $('#datatable').DataTable();
				var botonEliminar = '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target=".modal-danger" onclick="IdentificaEliminar('+id+')"><i class="fa fa-trash"></i></button></td>';
				tabla.row.add([
					//idGrupo,
					//RJson.id,
					RJson.nombre,
					RJson.apaterno,
					RJson.amaterno,
					botonEliminar
				]).draw().node().id="row_"+id;
			
			//alert(RJson.mensaje);
			}else{
				Swal.fire("Este usuario ya fue agregado");
			}
		},
		error: function (data) {
			// body...
			Swal.fire("No se puede agregar el usuario");
		}
	});
	mostrarNotify(id);
}

function mostrarNotify(id){
	let id_usuario = id; 
	//alert(id_usuario);
	let idGrupo = $('#idGrupo').val();
	
	$.ajax({
		url: 'actionNotify.php',
		type: 'POST',
		data: {id_usuario: id, idGrupo:idGrupo, accion:'agregar'},
		success: function(Resultado) {
			// body...
			//alert(Resultado);
			var RJSON = JSON.parse(Resultado);
		},
		error: function (data) {
			Swal.fire("Ocurrió un error");
		}
	});
}



function deleteUser() {
	// body...
	var tabla = $('#datatable').DataTable();
	var idGrupo = $('#idGrupo').val();

	$.ajax({
		url: "actionDeleteUser.php",
		type: "POST",	
		data: {id:idEliminar,idGrupo:idGrupo,
			accion: 'eliminar'},
		success: function(Resultado){
			//alert(Resultado);
			var res=JSON.parse(Resultado);
			if (res.estado==1) {
				tabla.row("#row_"+idEliminar).remove().draw();
			}
			Swal.fire(res.mensaje);
			//alert(res.mensaje);
		},
		error: function(data){
			Swal.fire("Ocurrió un error");
		}
	});

}