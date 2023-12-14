
/* Confirmar */
(function ($) {

    "use strict";
    $(function () {

        $.validator.setDefaults({
            submitHandler: function (event) {
                forgnewpar();
            }
        });
        $('#quickFormforgnew').validate({
            rules: {
                new_code: {
                    required: true,

                }
            },
            messages: {
                new_code: {
                    new_code: "Informe sua nova senha",

                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

    });

})(jQuery);



function forgnewpar() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    var has_errors = false,
        form = $(this),
        form_fields = form.find('span');

    form_fields.each(function () {
        if ($(this).hasClass('error')) {
            has_errors = true;
        }
    });

    var datastring = form.serialize();

    if (!has_errors) {
        document.getElementById('register').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('register').disabled = true;
        new_code = document.getElementById('new_code').value;
        token = document.getElementById('token').value;

        dados = {
            token: token,
            new_code: new_code
        }

        $.ajax({
            url: '/configuracaodeNovasenha',
            type: 'post',
            data: dados,
            dataType: 'json',
            timeout: 40000,

        }).done(function (msg) {

            if (msg.erro) {


                document.getElementById('register').innerHTML = `Criar Nova`;
                document.getElementById('register').disabled = false;
                console.log(msg)

                Toast.fire({
                    icon: 'info',
                    title: `${msg.mensagem} `
                })

            } else {
                console.log(msg)
                sucessoCarregdo(msg.mensagem)
                window.location.href='/login'
                //
            }

        }).fail(function (data) {
            Toast.fire({
                icon: 'info',
                title: `Erro na conexão`
            })

            console.log(data.responseText)
        })
    }

    return false;
}






/* Confirmar */
(function ($) {

    "use strict";
    $(function () {

        $.validator.setDefaults({
            submitHandler: function (event) {
                forgconfirme();
            }
        });
        $('#quickFormforgConfirm').validate({
            rules: {
                my_code: {
                    required: true,

                }
            },
            messages: {
                my_code: {
                    my_code: "Informe o código enviado",

                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

    });




})(jQuery);



function forgconfirme() {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    var has_errors = false,
        form = $(this),
        form_fields = form.find('span');

    form_fields.each(function () {
        if ($(this).hasClass('error')) {
            has_errors = true;
        }
    });

    var datastring = form.serialize();

    if (!has_errors) {
        document.getElementById('register').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('register').disabled = true;
        my_code = document.getElementById('my_code').value;
        token = document.getElementById('token').value;

        dados = {
            token: token,
            my_code: my_code
        }

        $.ajax({
            url: '/confirmarCode',
            type: 'post',
            data: dados,
            dataType: 'json',
            timeout: 40000,

        }).done(function (msg) {

            if (msg.erro) {


                document.getElementById('register').innerHTML = `Confirmar senha`;
                document.getElementById('register').disabled = false;
                console.log(msg)

                Toast.fire({
                    icon: 'info',
                    title: `${msg.mensagem} `
                })

            } else {
                console.log(msg)
                sucessoCarregdo(msg.mensagem)
                window.location.href='/redifinirsenha'
                //
            }

        }).fail(function (data) {
            Toast.fire({
                icon: 'info',
                title: `Erro na conexão`
            })

            console.log(data.responseText)
        })
    }

    return false;
}




/* HISTORIA */
(function ($) {

    "use strict";

    /*   $("form.mf_form_validate_forgEmail").each(function () {
          $(this).validate({
              rules: {
                  my_email: {
                      required: true,
                      email:true
                  }
              },
              messages: {
                  my_email: {
                      required: "seu email",
                      email:"informe um email valido"
                  }
              },
          });
      }); */
    $(function () {

        $.validator.setDefaults({
            submitHandler: function (event) {
                forgpassword();
            }
        });
        $('#quickFormforg').validate({
            rules: {
                my_email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                my_email: {
                    required: "seu email",
                    email: "informe um email valido"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

    });




})(jQuery);



function forgpassword() {


    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    var has_errors = false,
        form = $(this),
        form_fields = form.find('span');

    form_fields.each(function () {
        if ($(this).hasClass('error')) {
            has_errors = true;
        }
    });

    var datastring = form.serialize();

    if (!has_errors) {
        document.getElementById('register').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('register').disabled = true;
        my_email = document.getElementById('my_email').value;
        token = document.getElementById('token').value;

        dados = {
            token: token,
            my_email: my_email
        }

        $.ajax({
            url: '/requestnewpassword',
            type: 'post',
            data: dados,
            dataType: 'json',
            timeout: 40000,

        }).done(function (msg) {

            if (msg.erro) {

                if (Boolean(msg.email)) {
                    document.getElementById('erroemail').innerHTML = `<span  class="text-danger" d-block >${msg.email}</span> `
                }else{
                    document.getElementById('erroemail').innerHTML =''
                }
                document.getElementById('register').innerHTML = `Recuperar senha`;
                document.getElementById('register').disabled = false;
                console.log(msg)

                Toast.fire({
                    icon: 'info',
                    title: `${msg.mensagem} `
                })

            } else {
                console.log(msg)
                sucessoCarregdo(msg.mensagem)
                window.location.href='/forgot_confirme'
                //
            }

        }).fail(function (data) {
            Toast.fire({
                icon: 'info',
                title: `Erro na conexão`
            })

            console.log(data.responseText)
        })
    }

    return false;
}

function sucessoCarregdo(msg) {
    Swal.fire(
        `RECUPERAÇÃO DE CONTA`,
        `${msg}`,
        'success',
    )
}
