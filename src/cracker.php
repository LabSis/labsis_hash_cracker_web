<?php

require_once '../config.php';

// Funcion para hacer peticiones con cURL
function hacer_peticion($url_recurso, $datos_entrada) {
    $datos = null;
    // Inicio curl
    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url_recurso);
    curl_setopt($sesion, CURLOPT_HTTPGET, false);
    curl_setopt($sesion, CURLOPT_POST, true);
    curl_setopt($sesion, CURLOPT_HEADER, false);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);

    // Convierte array asociativo de datos en entrada en un string URL encodeado.
    $string_datos_entrada = http_build_query($datos_entrada);

    curl_setopt($sesion, CURLOPT_POSTFIELDS, $string_datos_entrada);

    // Ejecuto
    $resultado = curl_exec($sesion);

    // Cierro curl
    curl_close($sesion);

    // Proceso la respuesta
    if ($resultado === false) {
        throw new Exception("Error al hacer petición.", 0, null);
    }
    $resultado = json_decode($resultado, true);
    if (!isset($resultado["estado"])) {
        // Error...
        throw new Exception("Respuesta con formato no reconocido.", 0, null);
    } else {
        $estado = $resultado["estado"];
        if ($estado === "ok") {
            $datos = $resultado["datos"];
        } else {
            throw new Exception($resultado["error"]["descripcion"], $resultado["error"]["id"], null);
        }
    }
    return $datos;
}

// URL del recurso del Servidor de Hashes Inversos
$url_recurso = "http://localhost/labsis_hash_cracker_web/src/mockup_respuesta_shi.php";

$hash = filter_input(INPUT_POST, "hash");
$algoritmo = filter_input(INPUT_POST, "algoritmo");

$respuesta = array(
    "estado" => ""
);

try {
    $datos = hacer_peticion($url_recurso, array("hash" => $hash, "algoritmo" => $algoritmo));
    $respuesta["estado"] = "ok";
    $respuesta["datos"] = $datos;
} catch (Exception $ex) {
    $respuesta["estado"] = "error";
    $respuesta["error"] = array(
        "id" => $ex->getCode(),
        "descripcion" => $ex->getMessage()
    );
}
// Asumo que la respuesta ya viene en el formato esperado (el json acordado).
//print_r($respuesta);
echo json_encode($respuesta);
