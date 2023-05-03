$(function () {

    $.validator.setDefaults({
        submitHandler: function (event) {
            submitLogin();
        }
    });
    $('#quickFormLogin').validate({
        rules: {
            email: {
                required: true,

            },
            password: {
                required: true,
            }
        },
        messages: {
            email: {
                required: "Por favor, insira um endereço de e-mail",
            },
            password: {
                required: "Por favor, forneça uma senha",
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



function submitLogin() {


    document.getElementById('login').innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('login').disabled = true;

    let token = document.getElementById('token').value
    let email = document.getElementById('email').value
    let password = document.getElementById('password').value

    data = {
        token: token,
        email: email,
        password: password,
    }

    $.ajax({
        url: '/authuser',
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
            if (Boolean(msg.email)) {
                document.getElementById('erroemail').innerHTML = `<span  class="text-danger" d-block >${msg.email}</span> `

            } else {
                document.getElementById('erroemail').innerHTML = ``
            }

            if (Boolean(msg.password)) {
                document.getElementById('erropassword').innerHTML = `<span  class="text-danger" d-block >${msg.password}</span> `
            } else {
                document.getElementById('erropassword').innerHTML = ``
            }

            localStorage.setItem("idMenu", 'dashboard');
            window.location.href='/dashboard';

        } else {

            document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}</span>
                </div>`


            console.log(msg)

            if (Boolean(msg.email)) {
                document.getElementById('erroemail').innerHTML = `<span  class="text-danger" d-block >${msg.email}</span> `

            } else {
                document.getElementById('erroemail').innerHTML = ``
            }


            if (Boolean(msg.password)) {
                document.getElementById('erropassword').innerHTML = `<span  class="text-danger" d-block >${msg.password}</span> `
            } else {
                document.getElementById('erropassword').innerHTML = ``
            }

            console.log(msg.password)
            document.getElementById('login').disabled = false;
            document.getElementById('login').innerHTML = `Entrar`;

        }
    }).fail(function (data) {

        console.log(data.responseText)
        document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text">Verifica a sua conexão</span>
        </div>`

        document.getElementById('login').disabled = false;
        document.getElementById('login').innerHTML = `Entrar`;
    });

}

