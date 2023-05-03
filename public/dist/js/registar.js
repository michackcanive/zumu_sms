function habilita_Btn() {
    var op = document.getElementById("numero").value;

    if (op == " " || op.length <= 8) {
        if (!document.getElementById('avancar').disabled)
            document.getElementById('avancar').disabled = true;
    } else if (op.length >= 9) {
        if (document.getElementById('avancar').disabled) document.getElementById('avancar').disabled = false;
    }
}

function habilita_Btn_senha() {
    var senha = document.getElementById("senha").value


    if (senha == " " || senha.length <= 3) {
        if (!document.getElementById('avancar').disabled) document.getElementById('avancar').disabled = true;
    } else if (senha.length > 3 && senha != " ") {
        if (document.getElementById('avancar').disabled) document.getElementById('avancar').disabled = false;
    }
}



$(function () {

    $.validator.setDefaults({
        submitHandler: function (event) {
            submitCreateUser();
        }
    });
    $('#quickForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 6
            },
            telefone: {
                required: true,
                minlength: 9,
                maxlength: 9
            },

            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 6
            },
            terms: {
                required: true
            },
        },
        messages: {
            name: {
                required: "Digite o nome completo",
                minlength: "Seu nome deve ter pelo menos 6 caracteres"
            },
            telefone: {
                required: "forneça o número de telefone",
                minlength: "O minimo de caracteres é de 9",
                maxlength: "O maximo de caracteres é de 9",
            },
            email: {
                required: "Por favor, insira um endereço de e-mail",
                email: "Por favor insira um endereço de e-mail válido"
            },
            password: {
                required: "Por favor, forneça uma senha",
                minlength: "Sua senha deve ter pelo menos 6 caracteres"
            },
            terms: "Por favor, aceite nossos termos"
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





function submitCreateUser() {

    document.getElementById('register').innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('register').disabled = true;

    let name = document.getElementById('name').value
    let regex = /^[a-záàâãéèêíïóôõöúçñ]+$/i;
    let valido = name.split(/ +/).every(parte => regex.test(parte));

    if (!valido) {
        document.getElementById('erroname').innerHTML = `Nome invalido`
        document.getElementById('register').disabled = false;
        document.getElementById('register').innerHTML = `Registar`;
        return;
    }

    let token = document.getElementById('token').value
    let email = document.getElementById('email').value
    let password = document.getElementById('password').value
    let telefone = document.getElementById('telefone').value
    let terms = document.getElementById('exampleCheck1').value

    data = {
        name: name,
        token: token,
        email: email,
        telefone: telefone,
        password: password,
        terms: terms
    }

    $.ajax({
        url: '/creteuser',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {

            document.getElementById('messagem').innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text">${msg.mensagem}! Bem-Vindo </span>
                </div>`

            localStorage.setItem("idMenu", 'dashboard');
            window.location.href = '/dashboard';

        } else {
         
            document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
            if (Boolean(msg.telefone)) {
                document.getElementById('errotelefone').innerHTML = `<span  class="text-danger" d-block >${msg.telefone}</span> `
            } else {
                document.getElementById('errotelefone').innerHTML = ``
            }
            document.getElementById('register').disabled = false;
            document.getElementById('register').innerHTML = `Registar`;

        }
    }).fail(function (data) {

        document.getElementById('messagem').innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text">Verifica a sua conexão</span>
        </div>`
        console.log(data.responseText)

        document.getElementById('register').disabled = false;
        document.getElementById('register').innerHTML = `Registar`;
    });

}

