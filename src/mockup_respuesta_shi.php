<?php

/**** Init ****/
// Poner en true en caso de que se produzca un error.
$error = false;
// Completar con los detalles del error ocurrido.
$objeto_error = array("id" => -1, "descripcion" => "");
// Completar con los datos obtenidos de ejecutar el programa java.
$objeto_datos = [];
// Lista de algoritmos validos
$lista_algoritmos = ["md5", "sha1", "sha224", "sha256", "sha384", "sha512"];

/*** Funciones ***/

/* Funcion que se encarga de validar que el
 * largo del hash coincida con el algoritmo
 * recibido
 * 
 * Parametros:
 * 	$largo_hash: largo a verificar
 * 	$algoritmo: algoritmo que debe coincidir
 * Retorno:
 * 	0 en caso de error, 1 de lo contrario
 */
function validarLargoHash($largo_hash_p, $algoritmo_p){
	switch($largo_hash_p){
		case 32:
			if($algoritmo_p !== "md5")return 0;
			break;
		case 40:
			if($algoritmo_p !== "sha1")return 0;
			break;
		case 56:
			if($algoritmo_p !== "sha224")return 0;
			break;
		case 96:
			if($algoritmo_p !== "sha384")return 0;
			break;
		case 128:
			if($algoritmo_p !== "sha512")return 0;
			break;
		default:
			return 0;
	}
	return 1;
}

/*** Main ***/
try {

    // Todo el procesamiento: ejecutar java y procesar respuesta aqui...
    // ...
    // Obtengo parametros de entrada:
    $hash = filter_input(INPUT_POST, "hash");
    $algoritmo = filter_input(INPUT_POST, "algoritmo");
    
    // Validamos algoritmo recibido		
	if($algoritmo == NULL || !in_array($algoritmo, $lista_algoritmos, TRUE))
		throw new Exception("Algoritmo no válido");
	
	// Validamos hash recibido	
	if($hash == NULL || !preg_match("/^[a-z0-9]+$/", $hash))
		throw new Exception("Hash con caracteres no válidos");
		
	$largo_hash = strlen($hash);
	if(!validarLargoHash($largo_hash, $algoritmo))
		throw new Exception("Tamaño de hash no válido");
		

    // Armo comando con parametros de entrada.
//    $comando = "/usr/bin/java \"$algoritmo\" \"$hash\""
//    exec($comando);
	
	 $objeto_datos = array("resultados" => array("1", "2", "3"));

    // Fin del procesamiento.
} catch (Exception $ex) {
    $error = true;
    $objeto_error = array("id" => 1, "descripcion" => $ex->getMessage());
}

// Creo respuesta como array, al final sera convertida en json.
$respuesta = array(
    "estado" => ($error === true) ? "error" : "ok"
);

if ($error === false) {
    $respuesta["datos"] = $objeto_datos;
} else {
    $respuesta["error"] = $objeto_error;
}

echo json_encode($respuesta);
/*** fin main ***/
