(function () {
    $(document).ready(function () {
        $("#formulario").submit(function (evt) {
            evt.preventDefault();
            var data = {
                hash: $("#txtHash").val().trim(),
                algoritmo: $("#slcAlgoritmos").val().trim(),
            };
            $.ajax({
                url: "src/cracker.php",
                type: "post",
                data: {}
            }).done(function (respuesta) {
                console.log(respuesta);
            });
        });
    });
})();