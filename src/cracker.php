<?php

require_once '../config.php';

// Funcion para hacer peticiones con cURL
function hacer_peticion($url_recurso) {
    $datos = null;
    // Inicio curl
    $sesion = curl_init();
    curl_setopt($sesion, CURLOPT_URL, $url_recurso);
    curl_setopt($sesion, CURLOPT_HTTPGET, true);
    curl_setopt($sesion, CURLOPT_HEADER, false);
    curl_setopt($sesion, CURLOPT_RETURNTRANSFER, true);

    // Ejecuto
    $resultado = curl_exec($sesion);
    
    // Cierro curl
    curl_close($sesion);
    
    // Proceso la respuesta
    if ($resultado === false) {
        throw new Exception("Error al hacer petición.", 0, null);
    }
    $resultado = json_decode($resultado);
    if (!property_exists($resultado, "estado")) {
        // Error...
        throw new Exception("Respuesta con formato no reconocido.", 0, null);
    } else {
        $estado = $resultado->estado;
        if ($estado === "ok") {
            $datos = $resultado->datos;
        } else {
            throw new Exception($resultado->error->descripcion, $resultado->error->id, null);
        }
    }
    return $datos;
}

// URL del recurso del Servidor de Hashes Inversos
$url_recurso = "http://localhost/labsis_hash_cracker_web/src/mockup_respuesta_shi.php";
$respuesta = hacer_peticion($url_recurso);
