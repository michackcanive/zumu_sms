(function ($) {

    "use strict";

    $("form.mf_form_validate_contacto").each(function () {
        $(this).validate({
            rules: {
                nome_contacto: {
                    required: true,
                },
                email_contacto: {
                    required: true
                },
                telefone: {
                    required: true,

                }
            },
            messages: {
                nome_contacto: {
                    required: "NOME DO CONCTATO "
                },
                email_contacto: {
                    required: "EMAIL DO CONCTATO"
                },
                telefone: {
                    required: "Informe o telemove",

                }
            },
        });
    });

    $("form.ajax_submit_contacto").on('submit', function (e) {
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
                        if (Boolean(data.email_contacto)) {
                            document.getElementById('erroemail_contacto').innerHTML = `<span  class="text-danger" d-block >${data.email_contacto}</span> `
                        } else {
                            document.getElementById('erroemail_contacto').innerHTML = ``
                        }

                        if (Boolean(data.telefone)) {
                            document.getElementById('errotelefone').innerHTML = `<span  class="text-danger" d-block >${data.telefone}</span> `
                        } else {
                            document.getElementById('errotelefone').innerHTML = ``
                        }
                        if (Boolean(data.nome)) {
                            document.getElementById('erronome').innerHTML = `<span  class="text-danger" d-block >${data.nome}</span> `
                        } else {
                            document.getElementById('erronome').innerHTML = ``
                        }

                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Criação de contacto')
                        document.getElementById('register').innerHTML = `Gravar`;
                        document.getElementById('register').disabled = false;

                        form.trigger("reset");
                        getContacto()
                    }
                },


                error: function (data) {
                    console.log(data.responseText)
                    Toast.fire({
                        icon: 'warnnig',
                        title: `${data.responseText} `
                    })
                    document.getElementById('register').innerHTML = `Gravar`;
                    document.getElementById('register').disabled = false;
                }
            });
        }
        return false;
    });
})(jQuery);



(function ($) {

    "use strict";

    $("form.mf_form_validate_import").each(function () {
        $(this).validate({
            rules: {
                file: {
                    required: true,
                }
            },
            messages: {
                file: {
                    required: "forneça um arquivo valido "
                }
            },
        });
    });

    $("form.ajax_submit_import").on('submit', function (e) {
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
            document.getElementById('register_Import').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('register_Import').disabled = true;


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
                        if (Boolean(data.file)) {
                            document.getElementById('errofile').innerHTML = `<span  class="text-danger" d-block >${data.file}</span> `
                        } else {
                            document.getElementById('errofile').innerHTML = ``
                        }


                        document.getElementById('register_Import').innerHTML = `Importar`;
                        document.getElementById('register_Import').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Contactos Importadados')
                        document.getElementById('register_Import').innerHTML = `Importar`;
                        document.getElementById('register_Import').disabled = false;

                        form.trigger("reset");
                        getContacto()
                    }
                },


                error: function (data) {

                    console.log(data.responseText)
                    Toast.fire({
                        icon: 'warnnig',
                        title: `${data.responseText} `
                    })
                    document.getElementById('register_Import').innerHTML = `Importar`;
                    document.getElementById('register_Import').disabled = false;
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



function deletaContacto(id, token) {
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


function Contactoeditar(id) {
    $(document).ready(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        document.getElementById('Editar' + id).innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
        document.getElementById('Editar' + id).disabled = true;

        var telefone = document.getElementById('telefone' + id).value
        var email_contacto = document.getElementById('email_contacto' + id).value
        var nome_contacto = document.getElementById('nome_contacto' + id).value

        var token = document.getElementById('token' + id).value


        var form_data = new FormData();

        form_data.append("email_contacto", email_contacto);
        form_data.append("id_contacto", id);
        form_data.append("nome_contacto", nome_contacto);
        form_data.append("token", token);
        form_data.append("telefone", telefone);



        $.ajax({
            url: "/createContacto",
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
                    $('#modal-edit' + id).modal('hide')
                    getContacto()

                }
                else {
                    Toast.fire({
                        icon: 'info',
                        title: `${data.mensagem}`
                    })
                    document.getElementById('Editar' + id).innerHTML = `EDITAR`;
                    document.getElementById('Editar' + id).disabled = false;

                    if (Boolean(data.email)) {
                        document.getElementById('erroemail_contacto' + id).innerHTML = `<span  class="text-danger" d-block >${data.email}</span> `
                    } else {
                        document.getElementById('erroemail_contacto' + id).innerHTML = ``
                    }
                    if (Boolean(data.numero_telefone)) {
                        document.getElementById('errotelefone' + id).innerHTML = `<span  class="text-danger" d-block >${data.numero_telefone}</span> `
                    } else {
                        document.getElementById('errotelefone' + id).innerHTML = ``
                    }
                    if (Boolean(data.nome)) {
                        document.getElementById('erronome' + id).innerHTML = `<span  class="text-danger" d-block >${data.nome}</span> `
                    } else {
                        document.getElementById('erronome' + id).innerHTML = ``
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

function getContacto(page) {

    document.getElementById('contactos').innerHTML = `<div id='contactos' class="text-center">
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
        url: '/getContactos',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        if (Boolean(msg.erro)) {
            errorActivete('verifica a sua ligação')
            document.getElementById('contactos').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }
        document.getElementById('contactos').innerHTML = msg
        reniciarTabela()
        document.getElementById('buscar').disabled = false;
    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        document.getElementById('buscar').disabled = false;
        //console.log(data.responseText)
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

function selecionados() {
    var checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
    var values = [];
    for (var i = 0; i < checkboxes.length; i++) {
        values.push(checkboxes[i].value);
    }
    console.log(values);

}
