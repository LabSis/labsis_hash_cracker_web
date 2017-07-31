<?php

// Poner en true en caso de que no se produzco un error.
$error = false;
// Completar con los detalles del error ocurrido.
$objeto_error = array("id" => -1, "descripcion" => "");
// Completar con los datos obtenidos de ejecutar el programa java.
$objeto_datos = [];

try {

    // Todo el procesamiento: ejecutar java y procesar respuesta aqui...
    // ...
    // Obtengo parametros de entrada:

    $hash = filter_input(INPUT_POST, "hash");
    $algoritmo = filter_input(INPUT_POST, "algoritmo");

    // Armo comando con parametros de entrada.
//    $comando = "java ...";

    $objeto_datos = array("resultados" => array("1", "2", "3"));

//    exec($comando);
    // Fin del procesamiento.
} catch (Exception $ex) {
    $error = true;
    $objeto_error = array("id" => 1, "descripcion" => "Error: " . $ex->getMessage());
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
