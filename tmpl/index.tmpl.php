<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>
            LabSis - Hash cracker
        </title>
        <link href="<?php echo $WEB_PATH; ?>css/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="<?php echo $WEB_PATH; ?>js/lib/jquery/jquery.min.js" ></script>
        <script src="<?php echo $WEB_PATH; ?>css/lib/bootstrap/js/bootstrap.min.js" ></script>
        <link href="<?php echo $WEB_PATH; ?>css/index.css" rel="stylesheet"/>
        <script src="<?php echo $WEB_PATH; ?>js/lib/validator-1.1.3.js" ></script>
        <script src="<?php echo $WEB_PATH; ?>js/index.js" ></script>
    </head>
    <body>
        <main class="container">
            <div class="col-sm-12">
                <div class="page-header">
                    <h1>
                        Hash Cracker
                    </h1>
                    <div class="explicacion">
                        <p>
                            ¿Cómo usarlo?
                        </p>
                        <ol>
                            <li>
                                Ingresa una clave hasheada en el campo de texto.
                            </li>
                            <li>
                                Selecciona el algoritmo de hash utilizado (o selecciona "Detectar automáticamente").
                            </li>
                            <li>
                                Presiona el botón "Buscar" y espera unos segundos para obtener la clave en texto plano.
                            </li>
                        </ol>
                        <div class="alert alert-info  alert-dismissible mas-info">
                            <p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                Las claves almacenadas tiene una longitud máxima de 12 caracteres. Si la clave que intentas buscar posee más caracteres, no será posible obtenerla.
                            </p>
                        </div>
                    </div>
                </div>
                <form class="form-inline" id='formulario'>
                    <div class="form-group">
                        <input type="text" class="form-control" id="txtHash" placeholder="Ingresa la clave hasheada aquí">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="slcAlgoritmos">
                            <option value="-1">
                                Seleccione algoritmo
                            </option>
                            <option value="auto">
                                Detectar automáticamente
                            </option>
                            <option value="MD5">
                                MD5
                            </option>
                            <option value="SHA1">
                                SHA-1
                            </option>
                            <option value="SHA224">
                                SHA-224
                            </option>
                            <option value="SHA256">
                                SHA-256
                            </option>
                            <option value="SHA384">
                                SHA-384
                            </option>
                            <option value="SHA512">
                                SHA-512
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnBuscar">
                        Buscar
                    </button>
                </form>
                <div class="hidden" id="resultados">
                    <div class="alert hidden" id='mensajeResultados'>
                        No se han encontrado resultado para el hash '';
                    </div>
                    <table class="table hidden" id="tablaResultados">
                        <thead>
                            <tr>
                                <th>
                                    Texto plano
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Resultado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
		
                <div class="pull-right">
	            <a href="https://github.com/LabSis/labsis_hash_cracker_web"> <img style="position:fixed; bottom: 0" src="https://assets-cdn.github.com/images/modules/logos_page/GitHub-Mark.png" width="100" height="100"></a>
	    	</div>
            </div>
        </main>
    </body>
</html>
