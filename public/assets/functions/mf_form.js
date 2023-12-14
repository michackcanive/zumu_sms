(function ($) {
    "use strict";

    /*     function use_recaptcha(){
            var site_key = '6LceXdwUAAAAAJxGDZxVUFyo5c33EYj0n6netovu';

            grecaptcha.ready(function() {
                grecaptcha.execute(site_key, {action: 'homepage'}).then(function(token) {
                    $("form.use_recaptcha").each(function(){
                        $(this).append('<input type="hidden" name="g-recaptcha-response" value="'+token+'" > ');
                    });
                });
            });
        }

        if( $("form.use_recaptcha").length > 0 ){
            use_recaptcha();
        }
     */
    $("form.mf_form_validate").each(function () {
        $(this).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                Subesubject: {
                    required: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "Por favor, insira um endereço de e-mail",
                    email: "Por favor insira um endereço de e-mail válido"
                },
                name: {
                    required: "Insira seu nome",
                },
                Subesubject: {
                    required: "Insira seu assunto",
                },
                message: {
                    required: "Informe a sua mensagem",
                }
            },
        });
    });

    $("form.ajax_submit").on('submit', function (e) {
        e.preventDefault();


        var has_errors = false,
            form = $(this),
            form_fields = form.find('input'),
            form_message = form.find('textarea'),
            server_result_display = form.find('.server_response');


        /*   var name = form.find('[name=name]').val(),
              email = form.find('[name=email]').val(),
              phone = form.find('[name=phone]').val(),
              subject = form.find('[name=subject]').val(),
              message = form.find('[name=message]').val(); */


        form_fields.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });

        if (form_message.length > 0) {
            if (form_message.hasClass('error')) {
                has_errors = true;
            }
        }


        var datastring = form.serialize();

        if (!has_errors) {
            document.getElementById('button').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('button').disabled = true;
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datastring,
                success: function (data) {

                    if (data.erro) {
                        console.log(data)
                        server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-danger  alert-dismissible">' + data.mensagem + ' <button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                        document.getElementById('button').innerHTML = `Enviar`;
                        document.getElementById('button').disabled = false;
                    }

                    else if (!data.erro) {
                        server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-success  alert-dismissible">' + data.mensagem + '<button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                        document.getElementById('button').innerHTML = `Enviar`;
                        document.getElementById('button').disabled = false;
                        setTimeout(function () {
                            $('form.ajax_submit .mf_alert').fadeOut(500);
                        }, 1500);
                        form.trigger("reset");
                    }
                },
                error: function () {
                    server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-danger  alert-dismissible">Server error! Please try again...<button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                }
            });
        }

        return false;
    });
})(jQuery);


(function ($) {
    "use strict";

    /*     function use_recaptcha(){
            var site_key = '6LceXdwUAAAAAJxGDZxVUFyo5c33EYj0n6netovu';

            grecaptcha.ready(function() {
                grecaptcha.execute(site_key, {action: 'homepage'}).then(function(token) {
                    $("form.use_recaptcha").each(function(){
                        $(this).append('<input type="hidden" name="g-recaptcha-response" value="'+token+'" > ');
                    });
                });
            });
        }

        if( $("form.use_recaptcha").length > 0 ){
            use_recaptcha();
        }
     */
    $("form.mf_form_validatemembro").each(function () {
        $(this).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                Subesubject: {
                    required: true,
                },
                message: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "Por favor, insira um endereço de e-mail",
                    email: "Por favor insira um endereço de e-mail válido"
                },
                name: {
                    required: "Insira seu nome",
                },
                Subesubject: {
                    required: "Insira seu assunto",
                },
                message: {
                    required: "Informe a sua mensagem",
                }
            },
        });
    });

    $("form.ajax_submitmembro").on('submit', function (e) {
        e.preventDefault();


        var has_errors = false,
            form = $(this),
            form_fields = form.find('input'),
            form_message = form.find('textarea'),
            server_result_display = form.find('.server_response');


        /*   var name = form.find('[name=name]').val(),
              email = form.find('[name=email]').val(),
              phone = form.find('[name=phone]').val(),
              subject = form.find('[name=subject]').val(),
              message = form.find('[name=message]').val(); */


        form_fields.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });

        if (form_message.length > 0) {
            if (form_message.hasClass('error')) {
                has_errors = true;
            }
        }


        var datastring = form.serialize();

        if (!has_errors) {
            document.getElementById('button').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('button').disabled = true;
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datastring,
                success: function (data) {


                    if (data.erro) {
                        Swal.fire(
                            'Envio de Email',
                            `${data.mensagem}`,
                            'info',
                        )
                        console.log(data)
                        server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-danger  alert-dismissible">' + data.mensagem + ' <button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                        document.getElementById('button').innerHTML = `Enviar`;
                        document.getElementById('button').disabled = false;
                    }

                    else if (!data.erro) {
                        Swal.fire(
                            ' Envio de Email😀',
                            `${data.mensagem}`,
                            'success',
                        )
                        server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-success  alert-dismissible">' + data.mensagem + '<button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                        document.getElementById('button').innerHTML = `Enviar`;
                        document.getElementById('button').disabled = false;
                        setTimeout(function () {
                            $('form.ajax_submitmembro .mf_alert').fadeOut(500);
                        }, 1500);
                        form.trigger("reset");
                    }
                    console.log(data)
                },
                error: function () {
                    server_result_display.empty().html('<div class="mb-0 mt-3 alert alert-danger  alert-dismissible">Server error! Please try again...<button type="button" class="close" data-bs-dismiss="alert">&times;</button></div>');
                }
            });
        }

        return false;
    });
})(jQuery);


function enviarEmail(id, id_igreja) {
    $(document).ready(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        document.getElementById('enviaremail' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('enviaremail' + id).disabled = true;

        var nome_membro = document.getElementById('nome_membro' + id).value
        var Subesubject = document.getElementById('Subesubject' + id).value
        var email_membro = document.getElementById('email_membro' + id).value
        var message = document.getElementById('message' + id).value
        var token = document.getElementById('token' + id).value

        if (nome_membro === '') {

            Toast.fire({
                icon: 'info',
                title: `Informe Nome 😓`
            })
            document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
            document.getElementById('enviaremail' + id).disabled = false;
            return
        }
        if (Subesubject === '') {

            Toast.fire({
                icon: 'info',
                title: `Informe o assunto 😓`
            })
            document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
            document.getElementById('enviaremail' + id).disabled = false;
            return
        }
        if (message === '') {

            Toast.fire({
                icon: 'info',
                title: `Informe a decrição 😓`
            })
            document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
            document.getElementById('enviaremail' + id).disabled = false;
            return
        }
        if (email_membro === '') {

            Toast.fire({
                icon: 'info',
                title: `Informe o email do Membro 😓`
            })
            document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
            document.getElementById('enviaremail' + id).disabled = false;
            return
        }



        var form_data = new FormData();
        form_data.append("id", id);
        form_data.append("nome_membro", nome_membro);
        form_data.append("Subesubject", Subesubject);
        form_data.append("email_membro", email_membro);
        form_data.append("message", message);
        form_data.append("token", token);

        $.ajax({
            url: "/envioemail_temos_email",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                //$("#preview").fadeOut();
                $("#err").fadeOut();
            },
            success: function (msg) {
                if (msg.erro === false) {
                    Toast.fire({
                        icon: 'success',
                        title: `${msg.mensagem} `
                    })
                    document.getElementById('message' + id).value = ''
                    document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
                    document.getElementById('enviaremail' + id).disabled = false;
                    //('#from_envioemail'+id).trigger("reset");
                    //setTimeout(function () { window.location.reload(); }, 2000);
                }
                else {

                    Toast.fire({
                        icon: 'info',
                        title: `${msg.mensagem} 😓`
                    })
                    document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
                    document.getElementById('enviaremail' + id).disabled = false;
                }
            },
            error: function (e) {
                console.log(e.responseText)
                Toast.fire({
                    icon: 'error',
                    title: 'Acção inesperada 😥.'
                })
                document.getElementById('enviaremail' + id).innerHTML = `Enviar`;
                document.getElementById('enviaremail' + id).disabled = false;
                // $("#err").html(e).fadeIn();
            }
        });
    });
}
