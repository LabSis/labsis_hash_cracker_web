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
                $.ajax({
                    url: getURL() + "src/cracker.php",
                    type: "post",
                    data: data
                }).done(function (respuesta) {
                    console.log(respuesta);
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
    
    function getURL(){
        return location.origin + "/labsis_hash_cracker_web/";
    }

})();