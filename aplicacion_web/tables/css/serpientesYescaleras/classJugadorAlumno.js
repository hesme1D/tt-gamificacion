	class Jugador
{
	constructor()
	{
		this.posicion = 0;
		this.id = "";
		this.posicionE=this.posicion;
	}

	recibirResultado(resultado,id,id2){
		//alert(resultado +"  "+ posiciones);
		//la primera vez que se lanza el dado se debe quedar en la pocision inicial es decir si cae 1, se queda en la casilla 1 y no en otra
		this.posicion = this.posicion + resultado;
		//alert(this.posicion);
		document.getElementById(id2). innerHTML = `Dado--> ${resultado}`;
		this.id = id;
		this.revisarPosicion(this.posicion,id2);
		//this.reiniciarFicha();
	}

	revisarPosicion(posicion,id2){
		//alert(posicion+" - "+id2);
		if(posicion >= 0 && posicion <= 10){
			switch(posicion)
			{
				case 1:
					document.getElementById('casilla_91').innerHTML= this.moverFicha();

				break;
				
				case 2:
					document.getElementById('casilla_92').innerHTML= this.moverFicha();
				break;

				case 3:
					document.getElementById('casilla_93').innerHTML= this.moverFicha();
				break;
				
				case 4:
					document.getElementById('casilla_94').innerHTML= this.moverFicha();
				break;

				case 5:
					document.getElementById('casilla_95').innerHTML= this.moverFicha();
				break;
				
				case 6:
					document.getElementById('casilla_96').innerHTML= this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Escalera!`;
					this.redireccionar();
					
				break;

				case 7:  
					document.getElementById('casilla_97').innerHTML=this.moverFicha();
				break;
				
				case 8:
					document.getElementById('casilla_98').innerHTML=this.moverFicha();
				break;

				case 9:  
					document.getElementById('casilla_99').innerHTML=this.moverFicha();
				break;
				
				case 10:
					document.getElementById('casilla_100').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 11 && posicion <= 20){
			switch(posicion)
			{
				case 11:  
					//this.reiniciar();
					document.getElementById('casilla_90').innerHTML= this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Escalera!`;
					this.redireccionar();					
				break;
				
				case 12:
					document.getElementById('casilla_89').innerHTML=this.moverFicha();
				break;

				case 13:  
					document.getElementById('casilla_88').innerHTML=this.moverFicha();
				break;
				
				case 14:
					document.getElementById('casilla_87').innerHTML=this.moverFicha();
				break;

				case 15:  
					document.getElementById('casilla_86').innerHTML=this.moverFicha();
				break;
				
				case 16:
					document.getElementById('casilla_85').innerHTML=this.moverFicha();
				break;

				case 17:  
					document.getElementById('casilla_84').innerHTML=this.moverFicha();
				break;
				
				case 18:
					document.getElementById('casilla_83').innerHTML=this.moverFicha();
				break;

				case 19:  
					document.getElementById('casilla_82').innerHTML=this.moverFicha();
				break;
				
				case 20:
					document.getElementById('casilla_81').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 21 && posicion <= 30){
			switch(posicion)
			{
				case 21:  
					document.getElementById('casilla_71').innerHTML=this.moverFicha();
				break;
				
				case 22:
					document.getElementById('casilla_72').innerHTML= this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Escalera`;
					this.redireccionar();
				break;
				case 23:  
					document.getElementById('casilla_73').innerHTML=this.moverFicha();
				break;
				
				case 24:
					document.getElementById('casilla_74').innerHTML=this.moverFicha();
				break;

				case 25:  
					document.getElementById('casilla_75').innerHTML=this.moverFicha();
				break;
				
				case 26:
					document.getElementById('casilla_76').innerHTML=this.moverFicha();
				break;

				case 27:  
					document.getElementById('casilla_77').innerHTML=this.moverFicha();
				break;
				
				case 28:
					document.getElementById('casilla_78').innerHTML=this.moverFicha();
				break;

				case 29:  
					document.getElementById('casilla_79').innerHTML=this.moverFicha();
				break;
				
				case 30:
					document.getElementById('casilla_80').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 31 && posicion <= 40){
			switch(posicion)
			{
				case 31:  
					document.getElementById('casilla_70').innerHTML=this.moverFicha();
				break;
				
				case 32:
					document.getElementById('casilla_69').innerHTML=this.moverFicha();
				break;
				case 33:  
					document.getElementById('casilla_68').innerHTML=this.moverFicha();
				break;
				
				case 34:
					document.getElementById('casilla_67').innerHTML=this.moverFicha();
				break;

				case 35:  
					document.getElementById('casilla_66').innerHTML=this.moverFicha();
				break;
				
				case 36:
					document.getElementById('casilla_65').innerHTML=this.moverFicha();
				break;

				case 37:  
					document.getElementById('casilla_64').innerHTML=this.moverFicha();
				break;
				
				case 38:
					document.getElementById('casilla_63').innerHTML=this.moverFicha();
				break;

				case 39:  
					document.getElementById('casilla_62').innerHTML=this.moverFicha();
				break;
				
				case 40:
					document.getElementById('casilla_61').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 41 && posicion <= 50){
			switch(posicion)
			{
				case 41:  
					document.getElementById('casilla_51').innerHTML=this.moverFicha();
				break;
				
				case 42:
					document.getElementById('casilla_52').innerHTML=this.moverFicha();
				break;
				case 43:  
					document.getElementById('casilla_53').innerHTML=this.moverFicha();
				break;
				
				case 44:
					document.getElementById('casilla_54').innerHTML=this.moverFicha();
				break;

				case 45:  
					document.getElementById('casilla_55').innerHTML=this.moverFicha();
				break;
				
				case 46:
					document.getElementById('casilla_56').innerHTML=this.moverFicha();
				break;

				case 47:  
					document.getElementById('casilla_57').innerHTML=this.moverFicha();
				break;
				
				case 48:
					document.getElementById('casilla_58').innerHTML=this.moverFicha();
				break;

				case 49:  
					document.getElementById('casilla_59').innerHTML=this.moverFicha();
				break;
				
				case 50:
					document.getElementById('casilla_60').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 51 && posicion <= 60){
			switch(posicion)
			{
				case 51:  
					document.getElementById('casilla_50').innerHTML=this.moverFicha();
				break;
				
				case 52:
					document.getElementById('casilla_49').innerHTML=this.moverFicha();
				break;
				case 53:  
					document.getElementById('casilla_48').innerHTML=this.moverFicha();
				break;
				
				case 54:
					document.getElementById('casilla_47').innerHTML=this.moverFicha();
				break;

				case 55:  
					document.getElementById('casilla_46').innerHTML=this.moverFicha();
				break;
				
				case 56:
					document.getElementById('casilla_45').innerHTML=this.moverFicha();
				break;

				case 57:  
					document.getElementById('casilla_44').innerHTML=this.moverFicha();
				break;
				
				case 58:
					document.getElementById('casilla_43').innerHTML=this.moverFicha();
				break;

				case 59:  
					document.getElementById('casilla_42').innerHTML=this.moverFicha();
				break;
				
				case 60:
					document.getElementById('casilla_41').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 61 && posicion <= 70){
			switch(posicion)
			{
				case 61:  
					document.getElementById('casilla_31').innerHTML=this.moverFicha();
				break;
				
				case 62:
					document.getElementById('casilla_32').innerHTML=this.moverFicha();
				break;
				case 63:  
					document.getElementById('casilla_33').innerHTML=this.moverFicha();
				break;
				
				case 64:
					document.getElementById('casilla_34').innerHTML=this.moverFicha();
				break;

				case 65:  
					document.getElementById('casilla_35').innerHTML=this.moverFicha();
				break;
				
				case 66:
					document.getElementById('casilla_36').innerHTML=this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Serpiente!`;
					this.redireccionar();
				break;

				case 67:  
					document.getElementById('casilla_37').innerHTML=this.moverFicha();
				break;
				
				case 68:
					document.getElementById('casilla_38').innerHTML=this.moverFicha();
				break;

				case 69:  
					document.getElementById('casilla_39').innerHTML=this.moverFicha();
				break;
				
				case 70:
					document.getElementById('casilla_40').innerHTML=this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Serpiente!`;
					this.redireccionar();
				break;			 
			}
		}else if(posicion >= 71 && posicion <= 80){
			switch(posicion)
			{
				case 71:  
					document.getElementById('casilla_30').innerHTML=this.moverFicha();
				break;
				
				case 72:
					document.getElementById('casilla_29').innerHTML=this.moverFicha();
				break;
				case 73:  
					document.getElementById('casilla_28').innerHTML=this.moverFicha();
				break;
				
				case 74:
					document.getElementById('casilla_27').innerHTML=this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Escalera!`;
					this.redireccionar();
					//this.posicion=95;
				break;

				case 75:  
					document.getElementById('casilla_26').innerHTML=this.moverFicha();
				break;
				
				case 76:
					document.getElementById('casilla_25').innerHTML=this.moverFicha();
				break;

				case 77:  
					document.getElementById('casilla_24').innerHTML=this.moverFicha();
				break;
				
				case 78:
					document.getElementById('casilla_23').innerHTML=this.moverFicha();
				break;

				case 79:  
					document.getElementById('casilla_22').innerHTML=this.moverFicha();
				break;
				
				case 80:
					document.getElementById('casilla_21').innerHTML=this.moverFicha();
				break;
			}
		}else if(posicion >= 81 && posicion <= 90){
			switch(posicion)
			{
				case 81:  
					document.getElementById('casilla_11').innerHTML=this.moverFicha();
				break;
				
				case 82:
					document.getElementById('casilla_12').innerHTML=this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Serpiente!`;
					this.redireccionar();
				break;
				case 83:  
					document.getElementById('casilla_13').innerHTML=this.moverFicha();
				break;
				
				case 84:
					document.getElementById('casilla_14').innerHTML=this.moverFicha();
				break;

				case 85:  
					document.getElementById('casilla_15').innerHTML=this.moverFicha();
				break;
				
				case 86:
					document.getElementById('casilla_16').innerHTML=this.moverFicha();
				break;

				case 87:  
					document.getElementById('casilla_17').innerHTML=this.moverFicha();
				break;
				
				case 88:
					document.getElementById('casilla_18').innerHTML=this.moverFicha();
				break;

				case 89:  
					document.getElementById('casilla_19').innerHTML=this.moverFicha();
				break;
				
				case 90:
					document.getElementById('casilla_20').innerHTML=this.moverFicha();
				break;			 
			}
		}else if(posicion >= 91 && posicion <= 99){
			switch(posicion)
			{
				
				case 91:  
					document.getElementById('casilla_10').innerHTML=this.moverFicha();
				break;
				
				case 92:
					document.getElementById('casilla_9').innerHTML=this.moverFicha();
				break;
				case 93:  
					document.getElementById('casilla_8').innerHTML=this.moverFicha();
				break;
				
				case 94:
					document.getElementById('casilla_7').innerHTML=this.moverFicha();
					document.getElementById(id2).innerHTML = `¡Serpiente!`;
					this.redireccionar();
				break;

				case 95:  
					document.getElementById('casilla_6').innerHTML=this.moverFicha();
				break;
				
				case 96:
					document.getElementById('casilla_5').innerHTML=this.moverFicha();
				break;

				case 97:  
					document.getElementById('casilla_4').innerHTML=this.moverFicha();
				break;
				
				case 98:
					document.getElementById('casilla_3').innerHTML=this.moverFicha();
				break;

				case 99:  
					document.getElementById('casilla_2').innerHTML=this.moverFicha();
				break;			 
			}
		}else{
			document.getElementById('casilla_1').innerHTML=this.moverFicha();
			document.getElementById('btn_1').disabled = true;
			generar();

		}
	}

	moverFicha(){
		this.reiniciarFicha();
		return '<div id="limpiar" class="clase"><img id="ficha1" width="40px" height="40px" src="../tables/images/ficha.png"></div>';
		
	}

	reiniciarFicha(){

		$(document).find('td').each (function() {
			$(this).html("")
		});
	}
	redireccionar(){
		$("#btn_pregunta").modal("show");
		//alert(this.posicion);
	}

	serpiente(){

		if(this.posicion >= 0 && this.posicion <= 10){
			switch(this.posicion)
			{		
				case 6:
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 45!`;
					document.getElementById('casilla_96').innerHTML=this.moverFicha();
					this.posicion=6;
				break;			 
			}

		}else if(this.posicion >= 11 && this.posicion <= 20){
			switch(this.posicion)
			{
				case 11:  
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 32!`;					
					document.getElementById('casilla_90').innerHTML= this.moverFicha();
					this.posicion=11;
				break;					 
			}
		}else if(this.posicion >= 21 && this.posicion <= 30){
			switch(this.posicion)
			{
				case 22:
					document.getElementById('casilla_72').innerHTML= this.moverFicha();
					this.posicion=22;
				break;		 
			}
		}else if(this.posicion>= 61 && this.posicion <= 70){
			switch(this.posicion)
			{				
				case 66:
					//document.getElementById(this.id2).innerHTML = `¡Bajas a casilla 8!`;
					document.getElementById('casilla_98').innerHTML=this.moverFicha();
					this.posicion=8;
				break;
				
				case 70:
					//document.getElementById(this.id2).innerHTML = `¡Bajas a casilla 27!`;
					document.getElementById('casilla_77').innerHTML=this.moverFicha();
					this.posicion=27;
				break;			 
			}
		}else if(this.posicion >= 71 && this.posicion <= 80){
			switch(this.posicion)
			{
						
				case 74:
					document.getElementById('casilla_27').innerHTML=this.moverFicha();
					this.posicion=74;
				break;
			}
		}else if(this.posicion >= 81 && this.posicion <= 90){
			switch(this.posicion)
			{
				case 82:
					//document.getElementById(this.id2).innerHTML = `¡Bajas a casilla 17!`;
					document.getElementById('casilla_84').innerHTML=this.moverFicha();
					this.posicion=17;
				break;
							 
			}
		}else if(this.posicion >= 91 && this.posicion <= 99){
			switch(this.posicion)
			{				
				case 94:
					document.getElementById('casilla_46').innerHTML=this.moverFicha();
					this.posicion=55;
				break;			 
			}
		}else{
			document.getElementById('casilla_1').innerHTML=this.moverFicha();
			document.getElementById('btn_1').disabled = true;

		}
	}

	escalera(){
		if(this.posicion >= 0 && this.posicion <= 10){
			switch(this.posicion)
			{		
				case 6:
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 45!`;
					document.getElementById('casilla_55').innerHTML=this.moverFicha();
					this.posicion=45;
				break;			 
			}

		}else if(this.posicion >= 11 && this.posicion <= 20){
			switch(this.posicion)
			{
				case 11:  
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 32!`;					
					document.getElementById('casilla_69').innerHTML=this.moverFicha();
					this.posicion=32;
				break;					 
			}
		}else if(this.posicion >= 21 && this.posicion <= 30){
			switch(this.posicion)
			{	
				case 22:
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 64!`;
					document.getElementById('casilla_34').innerHTML=this.moverFicha();
					this.posicion=64;
				break;			 
			}
		}else if(this.posicion >= 61 && this.posicion <= 70){
			switch(this.posicion)
			{				
				case 66:
					document.getElementById('casilla_36').innerHTML=this.moverFicha();
					this.posicion=66;
				break;
				
				case 70:
					document.getElementById('casilla_40').innerHTML=this.moverFicha();
					this.posicion=70;
				break;			 
			}
		}else if(this.posicion >= 71 && this.posicion <= 80){
			switch(this.posicion)
			{				
				case 74:
					//document.getElementById(this.id2).innerHTML = `¡Felicidades, subes a casilla 95!`;
					document.getElementById('casilla_6').innerHTML=this.moverFicha();
					this.posicion=95;
				break;
			}
		}else if(this.posicion >= 81 && this.posicion <= 90){
			switch(this.posicion)
			{
				case 82:
					document.getElementById('casilla_12').innerHTML=this.moverFicha();
					this.posicion=82;
				break;			 
			}
		}else if(this.posicion >= 91 && this.posicion <= 99){
			switch(this.posicion)
			{
				
				case 94:
					document.getElementById('casilla_7').innerHTML=this.moverFicha();
					this.posicion=94;
				break;
			}
		}else{
			document.getElementById('casilla_1').innerHTML=this.moverFicha();
			document.getElementById('btn_1').disabled = true;
		}
	}

	rankingActiv(){
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

}