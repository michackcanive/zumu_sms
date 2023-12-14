$(function () {

    $.validator.setDefaults({
        submitHandler: function (event) {
            submitCodefimar();
        }
    });
    $('#quickFormConfimar').validate({
        rules: {
            codeConfimar: {
                required: true,

            }
        },
        messages: {
            codeConfimar: {
                required: "Por favor, insira o código",
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

function submitCodefimar() {

    let token = document.getElementById('token').value
    let codeConfimar = document.getElementById('codeConfimar').value

    if (codeConfimar == '') {
        alert('Foneça o código envido')
        return
    }

    document.getElementById('btn_confimar').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>
    </div>`;
    document.getElementById('btn_confimar').disabled = true;
    data = {
        token: token,
        codeConfimar: codeConfimar,
    }

    $.ajax({
        url: '/confimarCode',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)

        if (!msg.erro) {

            document.getElementById('messagem').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}</span>
                </div>`

            localStorage.setItem("idMenu", 'dashboard');
            window.location.href = '/dashboard';

        } else {
            document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}</span>
                </div>`

            if (Boolean(msg.code)) {
                document.getElementById('errocodigo').innerHTML = `<span  class="text-danger" d-block >${msg.code}</span> `

            } else {
                document.getElementById('errocodigo').innerHTML = ``
            }

            document.getElementById('btn_confimar').disabled = false;
            document.getElementById('btn_confimar').innerHTML = `Confirmar`;

        }
    }).fail(function (data) {

        console.log(data.responseText)
        document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small class="alert-text">Verifica a sua conexão</small>
        </div>`


        document.getElementById('btn_confimar').disabled = false;
        document.getElementById('btn_confimar').innerHTML = `Confirmar`;
    });

}

function renviarcodigo() {


    let token = document.getElementById('token').value

    document.getElementById('btn_renviar_confimar').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>
    </div>`;
    document.getElementById('btn_renviar_confimar').disabled = true;
    data = {
        token: token,
    }

    $.ajax({
        url: '/renviar_codigo',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)

        if (!msg.erro) {

            document.getElementById('messagem').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}</span>
                </div>`

            localStorage.setItem("idMenu", 'dashboard');
            window.location.href = '/dashboard';

        } else {
            document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}</span>
                </div>`

            if (Boolean(msg.code)) {
                document.getElementById('errocodigo').innerHTML = `<span  class="text-danger" d-block >${msg.code}</span> `

            } else {
                document.getElementById('errocodigo').innerHTML = ``
            }

            document.getElementById('btn_renviar_confimar').disabled = false;
            document.getElementById('btn_renviar_confimar').innerHTML = `renviar código`;

        }
    }).fail(function (data) {

        console.log(data)
        document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small class="alert-text">Verifica a sua conexão</small>
        </div>`


        document.getElementById('btn_renviar_confimar').disabled = false;
        document.getElementById('btn_renviar_confimar').innerHTML = `renviar código`;
    });

}
