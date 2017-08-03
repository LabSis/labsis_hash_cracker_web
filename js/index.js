(function () {
    $(document).ready(function () {

        var validator = ValidatorJS.createValidator({
            form: $("#formulario"),
            triggers: [ValidatorJS.VALIDATE_ON_FORM_SUBMIT, ValidatorJS.VALIDATE_ON_FIELD_BLUR],
            validField: function (args) {
                var $campo = args.field;
                var idCampo = $campo.get(0).id;
                $campo.closest(".form-group").removeClass("has-error");
                $campo.attr('data-original-title', "");
            },
            invalidField: function (args) {
                var $campo = args.field;
                $campo.closest(".form-group").addClass("has-error");
                $campo.tooltip(
                        {
                            title: "",
                            trigger: "focus",
                            html: true
                        });
                $campo.data("mensajesTooltip", args.messages);
                var textoTooltip = "";
                for (var i = 0; i < $campo.data("mensajesTooltip").length; i++) {
                    textoTooltip += $campo.data("mensajesTooltip")[i].texto + "<br/>";
                }
                $campo.attr('data-original-title', textoTooltip);
            },
            invalidForm: function (args) {
            },
            validForm: function (args) {
                args.event.preventDefault();
                var data = {
                    hash: $("#txtHash").val().trim(),
                    algoritmo: $("#slcAlgoritmos").val().trim(),
                };
                var hash = data.hash;
                $.ajax({
                    url: getURL() + "src/cracker.php",
                    type: "post",
                    dataType: "json",
                    data: data
                }).done(function (respuesta) {
                    $("#resultados").removeClass("hidden");
                    $("#tablaResultados").addClass("hidden");
                    if (respuesta.estado === undefined) {
                        mostrarMensajeResultado("Error al buscar hash '" + hash + "'.", "error");
                    } else {
                        if (respuesta.estado === "ok" && respuesta.datos !== undefined && respuesta.datos.resultados !== undefined) {
                            if (respuesta.datos.resultados.length > 0) {
                                mostrarMensajeResultado("Hash '" + hash + "' encontrado.", "exito");
                                $("#tablaResultados tbody").empty();
                                for (var i = 0; i < respuesta.datos.resultados.length; i++) {
                                    var $tr = $('<tr></tr>');
                                    var $td = $('<td></td>');
                                    $td.text(respuesta.datos.resultados[i]);
                                    $tr.append($td);
                                    $("#tablaResultados tbody").append($tr);
                                }
                                $("#tablaResultados").removeClass("hidden");
                            } else {
                                mostrarMensajeResultado("Hash '" + hash + "' no encontrado.", "alerta");
                            }
                        } else {
                            mostrarMensajeResultado("Error al buscar hash '" + hash + "'.", "error");
                        }
                    }
                });
            },
            validValidation: function (args) {
                var $campo = args.field;
                var idCampo = args.field.attr("id");
                var idTipoValidacion = args.validation.validationType;
                var mensajesTooltip = $campo.data("mensajesTooltip");
                if (mensajesTooltip === undefined) {
                    mensajesTooltip = [];
                }
                for (var i = 0; i < mensajesTooltip.length; i++) {
                    if (mensajesTooltip[i].idTipoValidacion === idTipoValidacion) {
                        mensajesTooltip.splice(i, 1);
                        break;
                    }
                }
                $campo.data("mensajesTooltip", mensajesTooltip);
            }

        });
        validator.addValidation($("#txtHash"), ValidatorJS.VALIDATION_TYPE_LENGTH, {max: 512, message: {idTipoValidacion: ValidatorJS.VALIDATION_TYPE_LENGTH, texto: "El hash no puede tener más de 512 caracteres."}});
        validator.addValidation($("#txtHash"), ValidatorJS.VALIDATION_TYPE_REQUIRED, {message: {idTipoValidacion: ValidatorJS.VALIDATION_TYPE_REQUIRED, texto: "El hash no puede estar vacío."}});
        validator.addValidation($("#slcAlgoritmos"), ValidatorJS.VALIDATION_TYPE_REQUIRED, {message: {idTipoValidacion: ValidatorJS.VALIDATION_TYPE_REQUIRED, texto: "El algoritmo no puede estar sin seleccionar."}});
    });

    function mostrarMensajeResultado(texto, tipo) {
        $("#mensajeResultados").removeClass("alert-warning");
        $("#mensajeResultados").removeClass("alert-success");
        if (tipo === "exito") {
            $("#mensajeResultados").addClass("alert-success");
        } else if (tipo === "info") {
            $("#mensajeResultados").addClass("alert-info");
        } else if (tipo === "alerta") {
            $("#mensajeResultados").addClass("alert-warning");
        } else {
            $("#mensajeResultados").addClass("alert-danger");
        }
        $("#mensajeResultados").text(texto);
        $("#mensajeResultados").removeClass("hidden");
    }

    function getURL() {
        return location.origin + "/labsis_hash_cracker_web/";
    }

})();