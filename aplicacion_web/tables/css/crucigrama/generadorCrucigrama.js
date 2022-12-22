const attemptsToFitWords = 5000;
const gridsToMake = 1;
const gridSize = 20;

let usedWords = [];
let generatedGrids = [];
let goodStartingLetters = new Set()

let slots = gridSize * gridSize;
let gridDiv = document.getElementById("grid");
let row = 0;
let column = 0;

let miGrid;
let misPalabras=[];
let todasMisPalabras=[];

let verticales=[];
let horizontales=[];
horizontales.push("Trampa");

let posH;
let posV;

for( let input = 0; input < slots; input++ ){
    let div = document.createElement("input");
    //div.readOnly=true;
    div.id = row + "_" + column; 
    div.classList.add("input");
    div.style.border =  '1px solid #e9e9e9';
    div.style.backgroundColor = '#e9e9e9';
    gridDiv.appendChild(div);
    column++;
    if( column >= gridSize ){
        column = 0;
        row++;
    }
    //Código que permite la entrada de sólo un caracter en el input
    $("#"+div.id).keypress(function(){
        if($("#"+div.id).val().length>0)
            $("#"+div.id).val("");
    });
}

//FUNCIONES
window.onload = function(){
	createCrossWordPuzzle();
};

let createCrossWordPuzzle = function() {
	// body...
	/*Toma una palabra dada e intenta colocarla en el crucigrama*/
	let attemptToPlaceWordOnGrid = function(grid, palabra){
        let text = getAWordToTry();
        for (let row = 0; row < gridSize; ++row){
            for (let column = 0; column < gridSize; ++column){
                palabra.text = text;
                palabra.row = row;
				palabra.column = column;
				palabra.vertical = Math.random() >= 0.5;

                if (grid.isLetter(row, column)){
                    if (grid.update(palabra)){
                        pushUsedWords(palabra.text);
                         if (palabra.vertical===true) {
                            verticales.push(palabra.text);
                         } else{
                            horizontales.push(palabra.text);
                         }

                        return true;
                    }
                }
            }
        }
        return false;
	}
    /*Muestra las palabras Horizontales en la tabla*/
    function muestraPalabrasHTabla() {
        // body...
        for (var i = 0; i<horizontales.length; i++) {
            let miPalabra=regresaDatos(horizontales[i],todasMisPalabras);
            $("#datatable1 > tbody:last-child").append('<tr><td>'+miPalabra.id+'</td><td>'+miPalabra.descripcion+'</td></tr>');   
        }
    }
    /*Muestra las palabras verticales en la tabla*/
    function muestraPalabrasVTabla() {
        // body...
        for (var i = 0; i<verticales.length; i++) {
            let miPalabra=regresaDatos(verticales[i],todasMisPalabras);
            $("#datatable2 > tbody:last-child").append('<tr><td>'+miPalabra.id+'</td><td>'+miPalabra.descripcion+'</td></tr>');   
        }
    }
    /*Regresa los datos de las palabras de la base de datos*/
    function regresaDatos(palabra,todasMisPalabras) {
        // body...
        for (var i=0; i<todasMisPalabras.length; i++) {
            if (palabra==todasMisPalabras[i].palabra){
                return todasMisPalabras[i];
            }
        }
        return "No encontrada";
    }
    /*Muestra el indicador de las casillas horizontales*/
    function casillaH() {
        // body...
        for (var i=0; i<horizontales.length; i++) {
            let miPalabra=regresaDatos(horizontales[i],todasMisPalabras);
            posH=posicionesH[i];
            miPalabra.id=posH[0];
            for (var row=0; row<gridSize;++row) {
                for (var column=0; column<gridSize;++column) {
                    let input = document.getElementById(row + "_" +column);
                    let temp = posH[0]+"_"+posH[1];
                    if (temp==input.id) {
                        input.placeholder=miPalabra.id;
                    }
                }
            }
        }
    }
    /*Muestra el indicador de las casillas verticales*/
    function casillaV() {
        // body...
        for (var i=0; i<verticales.length; i++) {
            let miPalabra=regresaDatos(verticales[i],todasMisPalabras);
            posV=posicionesV[i];
            miPalabra.id=posV[1];
            for (var row=0; row<gridSize;++row) {
                for (var column=0; column<gridSize;++column) {
                    let input = document.getElementById(row + "_" +column);
                    let temp = posV[0]+"_"+posV[1];
                    if (temp==input.id) {
                        input.placeholder=miPalabra.id;
                    }
                }
            }
        }
    }
	/*Busca una palabra que queremos intentar colocar en el crucigrama*/
	let getAWordToTry = function(){
        let palabra = getRandomWord(words);
        let goodWord = isGoodWord(palabra);

        while ( usedWords.includes(palabra) || !goodWord)
        {
            palabra = getRandomWord(words);
            goodWord = isGoodWord(palabra);
        }

        return palabra;
    }
	/*Elige el mejor crucigrama de los que se generaron*/
	let getBestGrid = function(grids){
        let bestGrid = grids[0];
        for(let grid of grids) {
            if (grid.getIntersections() >= bestGrid.getIntersections()){
                bestGrid = grid;
            }
        }
        return bestGrid;
    }
	/*Determina si una palabra es una buena candidata para intentar colocarla en el crucigrama*/
	let isGoodWord = function(palabra){
        let goodWord = false;
        for(let letter of goodStartingLetters){
            if( letter === palabra.charAt(0)){
                goodWord = true;
                break;
            }
        }
        return goodWord;
    }
	/*Genera muchos crucigramas*/
	let generateGrids = function(){
        generatedGrids = [];

        for (let gridsMade = 0; gridsMade < gridsToMake; gridsMade++){
            let grid = new CrosswordPuzzle();
            let palabra = new Palabra(getRandomWordOfSize(getUnusedWords(), 9),
                                         0, 0, false);
            grid.update(palabra);
            pushUsedWords(palabra.text);

            let continuousFails = 0;
            for (let attempts = 0; attempts < attemptsToFitWords; ++attempts){
                let placed = attemptToPlaceWordOnGrid(grid, palabra);
                if(placed){
                    continuousFails = 0;
                }
                else{
                    continuousFails++;
                }
                if( continuousFails > 470 ){
                    break;
                }
            }

            generatedGrids.push(grid);
            if( grid.getIntersections() >= 4 ){
                break;
            }
            misPalabras=usedWords;
            horizontales[0]=misPalabras[0];
            miGrid=grid.grid;

            usedWords = [];
        }
    }
	/*Muestra el crucigrama en la pantalla*/
	let displayCrosswordPuzzle = function( bestGrid ){      
        for (let row = 0; row < gridSize; ++row){
            for (let column = 0; column < gridSize; ++column){
                let input = document.getElementById(row + "_" + column);
                if( bestGrid.isLetter(row, column)){
                    input.innerHTML = bestGrid.grid[row][column];
                    input.style.borderBottom =  '1px solid #9a8e9a';
                    input.style.borderRight =  '1px solid #9a8e9a';
                    input.style.backgroundColor = '#78E58F'; 
                    casillaH();
                    casillaV();
                }
                else{
                    input.readOnly=true;
                    input.innerHTML = "";
                    input.style.border =  '1px solid #e9e9e9';
                    input.style.backgroundColor = '#e9e9e9';
                }
            }
        }
    }
	/*Marca una palabra como usada y agrega sus letras a una lista de palabras presentes en el crucigrama*/
	let pushUsedWords = function( text ){
        usedWords.push(text);
        text.split('').filter( char => goodStartingLetters.add(char));
    }
    generateGrids();
	let bestGrid = getBestGrid(generatedGrids);
    displayCrosswordPuzzle(bestGrid);
    muestraPalabrasHTabla();
    muestraPalabrasVTabla();
}
/*Palabras no utilizadas*/
function getUnusedWords(){
	return words.filter(val => !usedWords.includes(val));
}
/*Palabra aleatoria según tamaño*/
function getRandomWordOfSize(wordList, wordSize){
	let properLengthWords = wordList.filter(val => val.length >= wordSize);
	return properLengthWords[getRandomInt(properLengthWords.length)]
}
/*Palabra aleatoria*/
function getRandomWord(wordList){
	let words = getUnusedWords();
	return words[getRandomInt(words.length)];
}
/*Entero aleatorio*/
function getRandomInt(max){
	return Math.floor(Math.random() * Math.floor(max));
}

/*Función para la pista*/
function mostrarPista() {
    // body...
    let indice = Math.floor(Math.random() * misPalabras.length);
    document.getElementById("npista").innerHTML=misPalabras[indice];
}
/*Deshabilita el botón una vez que fue presionado*/
function desabilitar(){
    document.querySelector('#pista').disabled=true;
}
/*Función para Validar las palabras*/
function validarPalabras(){
    // body...
    for(let i=0; i<20; i++){
        for(let j=0; j<20; j++){
            if(miGrid[i][j]!='_'){
                if($("#"+i+"_"+j).val().toUpperCase()!=miGrid[i][j])
                    return false;
            }
        }
    }
    return true;   
}
/*Procesa que se ingresaron los datos correctos*/
function procesaCrucigrama(){
    if(validarPalabras()==true){
        swal.fire({
            title: "Crucigrama Correcto",
        }).then(function() {
            // body...
        });
    }else{
        swal.fire({
            title: "Crucigrama Incorrecto",
        }).then(function() {
            // body...
        });
    }
}