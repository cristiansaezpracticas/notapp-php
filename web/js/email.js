    $('#email').blur(function () {
        if ($('#email').val() != "") {
            $.ajax({
                url: "existe_email",
                method: "POST",
                data: {email: $('#email').val()},
                success: function (data) {
                    if (data.respuesta) {
                        $('#boton_registrar').attr("disabled", "disabled");
                        $("#preloader").css('display', 'none');
                        bootbox.alert("Ya estás registrado con ese email. Inicia sesión.");
                    } else {
                        $('#boton_registrar').removeAttr("disabled");
                    }
                },
                dataType: "json",
                beforeSend: function () {
                    $("#preloader").css('display', 'inline');
                },
                complete: function () {
                    $("#preloader").css('display', 'none');
                }
            }); //$.ajax
        }   //If
    }); //blur