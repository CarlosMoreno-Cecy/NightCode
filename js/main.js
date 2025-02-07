$(document).ready(function () {


    // Función para procesar la petición del formulario
    $('#do_contact_form').on('submit', do_contact_form);
    function do_contact_form(event) {
        event.preventDefault();

        var data = new FormData($('do_contact_form').get(0));
        var wrapper_msg = $('.wrapper_msg'),
            wrapper_contact_form = $('.wrapper_contact_form'),
            submit_button = $('submit_button'),
            submit_button_default = submit_button.html();

        // Petición ajax
        $.ajax({
            url: 'procesos/ajax.php',
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            beforeSend: function () {
                submit_button.html('Enviando...');
            }
        }).done(function (res) {
            if (res.status === 200) {
                wrapper_msg.addClass('alert alert-success');
                wrapper_msg.html(res.msg);
                wrapper_contact_form.html(res.data);
            } else {
                wrapper_msg.addClass('alert alert-danger');
                wrapper_msg.html(res.msg);
                submit_button.html() = submit_button_default;
            }
        }).always(function () {

        }).fail(function (err) {
            wrapper_msg.html('Hubo un error en la petición');
            wrapper_msg.addClass('alert alert-danger');
            submit_button.html() = submit_button_default;
        });
    }
});