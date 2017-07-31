<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>
            LabSis - Hash cracker
        </title>
        <link href="<?php echo $WEB_PATH; ?>css/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="<?php echo $WEB_PATH; ?>js/lib/jquery/jquery.min.js" ></script>
        <script src="<?php echo $WEB_PATH; ?>css/lib/bootstrap/js/bootstrap.min.js" ></script>
        <link href="<?php echo $WEB_PATH; ?>css/index.css" rel="stylesheet"/>
    </head>
    <body>
        <main class="container">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>
                        Hash Cracker
                    </h1>
                    <p class="explicacion">
                        Ingresa una clave hasheada en el campo de texto, selecciona el algoritmo de hash utilizado (o selecciona "Detectar automáticamente"), y presiona en "Buscar" para obtener la clave en texto plano.
                    </p>
                </div>
                <form class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" id="txtHash" placeholder="Ingresa la clave hasheada aquí">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="slcAlgoritmos">
                            <option value="seleccione">
                                Selecciona el algoritmo
                            </option>
                            <option value="md5">
                                MD5
                            </option>
                            <option value="sha1">
                                SHA-1
                            </option>
                            <option value="sha224">
                                SHA-224
                            </option>
                            <option value="sha256">
                                SHA-256
                            </option>
                            <option value="sha384">
                                SHA-384
                            </option>
                            <option value="sha512">
                                SHA-512
                            </option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="btnBuscar">
                        Buscar
                    </button>
                </form>
                <div class="resultados">
                    <table>
                        <tr>
                            
                        </tr>
                    </table>
                </div>
            </div>
        </main>
    </body>
</html>