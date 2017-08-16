<?php

/* * ** Init *** */
// Poner en true en caso de que se produzca un error.
$error = false;
// Completar con los detalles del error ocurrido.
$objeto_error = array("id" => -1, "descripcion" => "");
// Completar con los datos obtenidos de ejecutar el programa java.
$objeto_datos = [];
// Lista de algoritmos validos
$lista_algoritmos = ["MD5", "SHA1", "SHA224", "SHA256", "SHA384", "SHA512"];
// Ubicación del jar compilado
$ubicacion_jar = "/var/www/GeneradorClaves/GeneradorClaves.jar";


/* * * Funciones ** */

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
    global $lista_algoritmos;
    switch ($largo_hash_p) {
        case 32:
            if ($algoritmo_p !== $lista_algoritmos[0])
                return 0;
            break;
        case 40:
            if ($algoritmo_p !== $lista_algoritmos[1])
                return 0;
            break;
        case 56:
            if ($algoritmo_p !== $lista_algoritmos[2])
                return 0;
            break;
        case 64:
            if ($algoritmo_p !== $lista_algoritmos[3])
                return 0;
            break;
        case 96:
            if ($algoritmo_p !== $lista_algoritmos[4])
                return 0;
            break;
        case 128:
            if ($algoritmo_p !== $lista_algoritmos[5])
                return 0;
            break;
        default:
            return 0;
    }
    return 1;
}

/* Funcion que procesa la respuesta de
 * la aplicación java y genera la respuesta
 * a enviar o una excepción en caso de error.
 *
 * Parametros:
 *    $respuesta_jar: respuesta del jar
 * Respuesta:
 *    String con la respuesta a enviar
 */

function procesarOutput($respuesta_jar){
    $salida_procesada = "";

    // Si encuentra la palabra "__ERROR__" o "null" en la respuesta, genera una excepción con el error
    if((strpos($respuesta_jar, '__ERROR__') !== false) || (strpos($respuesta_jar, 'null') !== false)){
        Throw new Exception("Error de la aplicación al procesar el hash");
    }
    /*
    * Acá pueden agregarse procesamientos de la salida en función de la respuesta recibida
    */
    $salida_procesada = $respuesta_jar;
    return $salida_procesada;
}

/* * * Main ** */
try {

    // Todo el procesamiento: ejecutar java y procesar respuesta aqui...
    // ...
    // Obtengo parametros de entrada:
    $hash = filter_input(INPUT_POST, "hash");
    $algoritmo = filter_input(INPUT_POST, "algoritmo");

    if($hash == NULL || $algoritmo == NULL)
	    throw new Exception("Parametros recibidos no válidos");

    // Validamos algoritmo recibido		
    if ($algoritmo == NULL || !in_array($algoritmo, $lista_algoritmos, TRUE))
        throw new Exception("Algoritmo no válido");

    // Validamos hash recibido	
    if ($hash == NULL || !preg_match("/^[a-z0-9]+$/", $hash))
        throw new Exception("Hash con caracteres no válidos");

    $largo_hash = strlen($hash);
    if (!validarLargoHash($largo_hash, $algoritmo))
        throw new Exception("Tamaño de hash no válido");


    // Armo comando con parametros de entrada.
    $comando = "/usr/bin/java -jar $ubicacion_jar run $algoritmo $hash";
    $respuesta_jar = exec($comando);
    
    $objeto_datos = array("resultados" => array(procesarOutput($respuesta_jar)));

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
