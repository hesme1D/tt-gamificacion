let posicionesH=[];
let posicionesV=[];

//Tablero Crucigrama
function CrosswordPuzzle() {
	// body...
	const emptyCell = '_';
	let grid = Array.from(Array(gridSize), () => new Array(gridSize));
	for( let row = 0; row < gridSize; row++ ){
		for( let column = 0; column < gridSize; column++ ){
			grid[row][column] = emptyCell;
		}
	}
	/*Trata de agregar la palabra al Grid*/
	let update = function(palabra){
		let updated = false;
		if( canBePlaced(palabra)){
			addWord(palabra);
			updated = true;
		}
		return updated;
	}
	/*Checa si una palabra puede ser agregada al grid*/
	let canBePlaced = function(palabra){
		let canBePlaced = true;
		if( isValidPosition(palabra.row, palabra.column) &&  fitsOnGrid(palabra)){
			let index = 0;
			while( index < palabra.text.length ){
				let currentRow = palabra.vertical ? palabra.row + index : palabra.row;
				let currentColumn = !palabra.vertical ? palabra.column + index : palabra.column;

				if((palabra.text.charAt(palabra) === grid[currentRow][currentColumn] ||
					emptyCell === grid[currentRow][currentColumn] ) &&
					placementLegal(palabra, currentRow, currentColumn)){
						//We can place a word! 
				}else{
					canBePlaced = false;
				}
				index++;
			}
		}
		else{
			canBePlaced = false;
		}

		return canBePlaced;
	}
	/*Devuelve un recuento del número de intersecciones de palabras en el grid*/
	let getIntersections = function(){
        let intersections = 0;
        for (let row = 0; row < gridSize; row++){
            for (let column = 0; column < gridSize; column++){
                if ( isLetter( row, column ) ){
                    if ( isValidPosition( row - 1, column ) &&
                         isValidPosition( row + 1, column ) &&
                         isValidPosition( row, column - 1 ) &&
                         isValidPosition( row, column + 1 ) &&
                         isLetter( row - 1, column ) &&
                         isLetter( row + 1, column ) &&
                         isLetter( row, column - 1 ) &&
                         isLetter( row, column + 1 ) ){
                        ++intersections;
                    }
                }
            }
        }
        return intersections;
    }
	/*Determina si una palabra se puede colocar legalmente en una posición específica de fila/columna*/
	let placementLegal = function(palabra, row, column){
		let illegal = false;
		if(palabra.vertical){
			illegal = isInterference(row, column + 1, row + 1, column) ||
					  isInterference(row, column - 1, row + 1, column) ||
					  overwritingVerticalWord(row, column) ||
					  invadingTerritory(palabra, row, column);

		}else{
			illegal = isInterference(row + 1, column, row, column + 1) ||
					  isInterference(row - 1, column, row, column + 1) ||
					  overwritingHorizontalWord(row, column) ||
					  invadingTerritory(palabra, row, column);

		}
		return !illegal;
	}
	/*Determina si una palabra invadirá el territorio de otra palabra en una determinada posición*/
	let invadingTerritory = function(palabra, row, column){
		let invading = false;
		let empty = isEmptyCell(row, column)
		if(palabra.vertical){
			let weHaveNeighbors = ( doesCharacterExist(row, column - 1) ||
					     		    doesCharacterExist(row, column + 1)) ||
									endOfWord(palabra, row, column) && 
									doesCharacterExist(row + 1, column);

			invading = empty && weHaveNeighbors;				
		}else{
			let weHaveNeighbors = (doesCharacterExist(row - 1, column) ||
					     		    doesCharacterExist(row + 1, column)) ||
									endOfWord(palabra, row, column) && 
									doesCharacterExist(row, column + 1);

			invading = empty && weHaveNeighbors;
		}
		return invading;
	}
	/*Determina si una posicion particular de fila/columna corresponde al final de la palabra*/
	let endOfWord = function(palabra, row, column){
		if(palabra.vertical){
			return palabra.row + palabra.text.length - 1 === row;
		}else{
			return palabra.column + palabra.text.length - 1 === column;
		}
	}
	/*Determina si un caracter existe en una determinada posición*/
	let doesCharacterExist = function(row, column){
		return isValidPosition(row, column) && 
			   isLetter(row, column);
	}
	/*Determina si colocar un caracter en una fila/columna en particular sobrescribiría una palabra horizontal*/
	let overwritingHorizontalWord = function(row, column){
        let leftColumn = column - 1;
        return ( isValidPosition(row, leftColumn) && 
        		 isLetter(row, column) && 
        		 isLetter(row, leftColumn));
    }
	/*Determina si colocar un caracter en una fila/columna en particular sobrescribiría una palabra vertical*/
	let overwritingVerticalWord = function(row, column){
        let rowAbove = row - 1;
        return ( isValidPosition(rowAbove, column) && 
        		 isLetter(row, column) && 
        		 isLetter(rowAbove, column));
    }
	/*Comprueba si hay interferencia en un conjunto de posiciones de fila/columna*/
	let isInterference = function(row, column, nextRow, nextColumn){
    	return isValidPosition(row, column) &&
    		   isValidPosition(nextRow, nextColumn) &&
    		   isLetter(row, column) &&
    		   isLetter(nextRow, nextColumn);	
    }
	/*Comprueba si hay una letra en una psoción de fila/columna*/
	let isLetter = function(row, column){
    	return grid[row][column] !== emptyCell;
    }
	/*Comprueba si una posición de fila/columna está vacía*/
	let isEmptyCell = function(row, column){
    	return !isLetter( row, column );
    }
	/*Agrega una palabra al grid*/
	let addWord = function(palabra){
		var posicion=new Array(palabra.row,palabra.column);

		if (palabra.vertical===true) {
			posicionesV.push(posicion);
		} else{
			posicionesH.push(posicion);
		}

		for (let letterIndex = 0; letterIndex < palabra.text.length; ++letterIndex)
        {
        	let row = palabra.row;
			let column = palabra.column;
	        if (palabra.vertical){
	            row += letterIndex;
	        }else{
	            column += letterIndex;
	        }

	        grid[row][column] = palabra.text.substring(letterIndex, letterIndex + 1);
        }
	}
	/*Comprueba si una palabra se ajusta a los límites del grid*/
	let fitsOnGrid = function(palabra){
		if(palabra.vertical){
			return palabra.row + palabra.text.length <= gridSize;
		}else{
			return palabra.column + palabra.text.length <= gridSize;
		}
	}
	/*Comprueba si una posición de fila/columna es válida para el grid*/
	let isValidPosition = function(row, column){
        return row >= 0 && row < gridSize && column >= 0 && column < gridSize;
    }

	return { 
		"grid": grid, 
		"update": update, 
		"isLetter": isLetter, 
		"getIntersections": getIntersections
	};
}