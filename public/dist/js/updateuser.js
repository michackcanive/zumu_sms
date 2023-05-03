

var input = false
function validatera(data, envet) {
    envet.preventDefault()
    $.validator.setDefaults({
        submitHandler: function () {
            input = true
            submitupadate(data)

        }
    });

    $('#update-user').validate({
        rules: {
            user_name: {
                required: true,
            },
            senha_user: {
                required: true,
            }
        },
        messages: {
            user_name: {
                required: "Nome do user",
            },
            senha_user: {
                required: "Senha de para confirmar",
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
}

$(function () {
    $('form[name="from_update-user"]').submit(function (event) {
        event.preventDefault();
        validatera(this, event);
        return;

    })
})

function submitupadate(data) {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    if (!input)
        return


    document.getElementById('btn-update_user').innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('btn-update_user').disabled = true;


    $.ajax({
        url: "/update_user",
        type: "POST",
        data: new FormData(data),
        contentType: false,
        dataType: 'json',
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
                setTimeout(function () { window.location.reload(); }, 2000);
                document.getElementById('btn-update_user').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
                document.getElementById('btn-update_user').disabled = false;
                // invalid file format.
                // $("#err").html("Invalid File !").fadeIn();
            }
            else {
                document.getElementById('btn-update_user').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
                document.getElementById('btn-update_user').disabled = false;

                Toast.fire({
                    icon: 'info',
                    title: `${msg.mensagem} 😓`
                })
            }
        },
        error: function (e) {
           
            document.getElementById('btn-update_user').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
            document.getElementById('btn-update_user').disabled = false;
            Toast.fire({
                icon: 'error',
                title: 'Acção inesperada 😥.'
            })
            // $("#err").html(e).fadeIn();
        }
    });
}

///////////////////////////////////////////////////////////
function validatera_senha(data, envet) {
    envet.preventDefault()
    $.validator.setDefaults({
        submitHandler: function () {
            input = true
            submitupadate_senha(data)
        }
    });

    $('#update-user-senha').validate({
        rules: {
            senha_actual: {
                required: true,
            },
            senha_nova: {
                required: true,
            },
            senha_confirmacao: {
                required: true,
            }
        },
        messages: {
            senha_actual: {
                required: "Senha actual",
            },
            senha_nova: {
                required: "Senha nova",
            },
            senha_confirmacao: {
                required: "Senha de para confirmar",
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
}

$(function () {
    $('form[name="from_update-senha-user"]').submit(function (event) {
        event.preventDefault();
        validatera_senha(this, event);
        return;

    })
})

function submitupadate_senha(data) {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    if (!input)
    return

    document.getElementById('btn-update_user-senha').innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('btn-update_user-senha').disabled = true;


    $.ajax({
        url: "/update_user_senha",
        type: "POST",
        data: new FormData(data),
        contentType: false,
        dataType: 'json',
        cache: false,
        processData: false,
        beforeSend: function () {
            //$("#preview").fadeOut();
            $("#err").fadeOut();
        },
        success: function (msg) {

            if (!msg.erro) {


                Toast.fire({
                    icon: 'success',
                    title: `${msg.mensagem} `
                })
                setTimeout(function () { window.location.reload(); }, 2000);
                document.getElementById('btn-update_user-senha').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
                document.getElementById('btn-update_user-senha').disabled = false;
                // invalid file format.
                // $("#err").html("Invalid File !").fadeIn();
            }
            else {
                document.getElementById('btn-update_user-senha').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
                document.getElementById('btn-update_user-senha').disabled = false;

                Toast.fire({
                    icon: 'info',
                    title: `${msg.mensagem} 😓`
                })
            }
        },
        error: function (e) {
            document.getElementById('btn-update_user-senha').innerHTML = `<button type="submit" class="btn btn-danger" id="btn-update_user-senha">Submit</button>`;
            document.getElementById('btn-update_user-senha').disabled = false;

            Toast.fire({
                icon: 'error',
                title: 'Acção inesperada 😥.'
            })
            // $("#err").html(e).fadeIn();
        }
    });
}
