(function ($) {

    "use strict";

    $("form.mf_form_validate_membro").each(function () {
        $(this).validate({
            rules: {
                nome_membro: {
                    required: true,
                },
                email_membro: {
                    required: true
                },
                password: {
                    required: true
                },
                telefone: {
                    required: true,

                }
            },
            messages: {
                nome_membro: {
                    required: "NOME DO MEMBRO "
                },
                email_membro: {
                    required: "EMAIL DO MEMBRO"
                },
                password: {
                    required: "SENHA DE ACESSO"
                },
                telefone: {
                    required: "Informe o telemove",

                }
            },
        });
    });

    $("form.ajax_submit_membro").on('submit', function (e) {
        e.preventDefault();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var has_errors = false,
            form = $(this),
            form_fields = form.find('input'),

            server_result_display = form.find('.server_response');

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

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    //moveupdate(valouePropostaBanner,id);
                    //$('#msg').html('Loading......');
                },
                success: function (data) {

                    if (data.erro === true) {

                        console.log(data)
                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem} `
                        })

                        if (Boolean(data.email_membro)) {
                            document.getElementById('erroemail_membro').innerHTML = `<span  class="text-danger" d-block >${data.email_membro}</span> `

                        } else {
                            document.getElementById('erroemail_membro').innerHTML = ``
                        }

                        if (Boolean(data.telefone)) {
                            document.getElementById('errotelefone').innerHTML = `<span  class="text-danger" d-block >${data.telefone}</span> `
                        } else {
                            document.getElementById('errotelefone').innerHTML = ``
                        }
                        if (Boolean(data.password)) {
                            document.getElementById('erropassword').innerHTML = `<span  class="text-danger" d-block >${data.password}</span> `
                        } else {
                            document.getElementById('erropassword').innerHTML = ``
                        }

                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Criação de membro')
                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        getMember()
                        form.trigger("reset");
                    }
                },


                error: function (data) {
                    console.log(data.responseText)
                    Toast.fire({
                        icon: 'warnnig',
                        title: `${data.responseText} `
                    })
                    document.getElementById('register').innerHTML = `Enviar`;
                    document.getElementById('register').disabled = false;
                }
            });
        }
        return false;
    });
})(jQuery);


function sucessoCarregdo(tipo_de_activacao) {
    Swal.fire(
        `${tipo_de_activacao}`,
        `Sucesso na criação do ${tipo_de_activacao}`,
        'success',
    )
}

function errorActivete(tipo_de_activacao) {
    Swal.fire(
        ` ${tipo_de_activacao}`,
        ` ${tipo_de_activacao}  `,
        'warning',
    )
}



function deletamembro(id, token) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    document.getElementById('delete' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
    document.getElementById('delete' + id).disabled = true;
    //var token = document.getElementById('token'+id).value;

    data = {
        id_membro: id,
        token: token
    }

    $.ajax({
        url: '/deletamember',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} `
            })
            getMember();
            document.getElementById('delete' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('delete' + id).disabled = true;
            setTimeout(function () { window.location.reload(); }, 2000);
        } else {
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem}!`
            })
            document.getElementById('delete' + id).innerHTML = 'deletar'
            document.getElementById('delete' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('delete' + id).disabled = false;

        }


    }).fail(function (data) {
        Toast.fire({
            icon: 'info',
            title: `Acção inesperada`
        })
        console.log(data.responseText)
        document.getElementById('delete' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('delete' + id).disabled = false;
        document.getElementById('delete' + id).innerHTML = 'deletar'

    })


}


function membroeditar(id) {
    $(document).ready(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        document.getElementById('register' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('register' + id).disabled = true;

        var nome_membro = document.getElementById('nome_membro' + id).value
        var email_membro = document.getElementById('email_membro' + id).value
        var senha_membro = document.getElementById('password' + id).value
        var telefone_cliente = document.getElementById('telefone' + id).value

        var token = document.getElementById('token' + id).value


        var form_data = new FormData();

        form_data.append("email_membro", email_membro);
        form_data.append("password", senha_membro);
        form_data.append("user_id", id);
        form_data.append("nome_membro", nome_membro);
        form_data.append("token", token);
        form_data.append("telefone", telefone_cliente);



        $.ajax({
            url: "/cretemember",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                //$("#preview").fadeOut();

                $("#err").fadeOut();
            },
            success: function (data) {
                if (data.erro === false) {
                    Toast.fire({
                        icon: 'success',
                        title: `${data.mensagem} `
                    })
                    //setTimeout(function () { window.location.reload(); }, 2000);
                    $('#modal-default' + id).modal('hide')
                    getMember()

                }
                else {

                    Toast.fire({
                        icon: 'info',
                        title: `${data.mensagem}`
                    })
                    document.getElementById('register' + id).innerHTML = `EDITAR`;
                    document.getElementById('register' + id).disabled = false;

                    if (Boolean(data.email_membro)) {
                        document.getElementById('erroemail_membro' + id).innerHTML = `<span  class="text-danger" d-block >${data.email_membro}</span> `

                    } else {
                        document.getElementById('erroemail_membro' + id).innerHTML = ``
                    }

                    if (Boolean(data.telefone)) {
                        document.getElementById('errotelefone' + id).innerHTML = `<span  class="text-danger" d-block >${data.telefone}</span> `
                    } else {
                        document.getElementById('errotelefone' + id).innerHTML = ``
                    }
                    if (Boolean(data.password)) {
                        document.getElementById('erropassword' + id).innerHTML = `<span  class="text-danger" d-block >${data.password}</span> `
                    } else {
                        document.getElementById('erropassword' + id).innerHTML = ``
                    }

                }
            },
            error: function (e) {
                console.log(e.responseText)
                Toast.fire({
                    icon: 'error',
                    title: 'Acção inesperada 😥.'
                })
                // $("#err").html(e).fadeIn();
            }
        });

    });
}

function getMember(page) {

    document.getElementById('member').innerHTML = `<div id='member' class="text-center">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
 </div>`
    let pesquisar = document.getElementById('pesquisar').value
    var token = document.querySelector('#token').value;
    document.getElementById('buscar').disabled = true;
    dados = {
        token: token,
        page: page ?? '',
        pesquisar: pesquisar ?? ''
    }
    $.ajax({
        url: '/getMember',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)
        if(Boolean(msg.erro)){

            errorActivete('verifica a sua ligação')
            document.getElementById('member').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }
        document.getElementById('member').innerHTML = msg
        let activeValue = document.getElementById('activado').value
        document.getElementById('activeValue').innerHTML = `${activeValue}`
        reniciarTabela()
        document.getElementById('buscar').disabled = false;
    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        document.getElementById('buscar').disabled = false;
        console.log(data.responseText)
    })
}


function reniciarTabela() {

    $("#example1").DataTable({
        "destroy": true,
        "searching": false,
        "paging": false,
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

}
