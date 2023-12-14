(function ($) {

    "use strict";

    $("form.mf_form_validate_grupo").each(function () {
        $(this).validate({
            rules: {
                nome_grupo: {
                    required: true,
                },
                descricao: {
                    required: true,
                }
            },
            messages: {
                nome_grupo: {
                    required: "NOME DO GRUPO "
                },
                descricao: {
                    required: "DESCRIÇÃO DO GRUPO "
                }
            },
        });
    });

    $("form.ajax_submit_grupo").on('submit', function (e) {
        e.preventDefault();
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var has_errors = false,
            form = $(this),
            form_fields_textarea = form.find('textarea'),
            form_fields = form.find('input'),

            server_result_display = form.find('.server_response');

        form_fields.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });
        form_fields_textarea.each(function () {
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
                    document.getElementById('register').innerHTML = `Gravar`;
                    document.getElementById('register').disabled = true;

                    if (data.erro === true) {
                        console.log(data)
                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem} `
                        })
                        if (Boolean(data.nome_grupo)) {
                            document.getElementById('erro_grupo').innerHTML = `<span  class="text-danger" d-block >${data.nome_grupo}</span> `
                        } else {
                            document.getElementById('erro_grupo').innerHTML = ``
                        }

                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Criação de grupo')
                        document.getElementById('register').innerHTML = `Gravar`;
                        document.getElementById('register').disabled = false;
                        form.trigger("reset");
                        getGrupo()
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



function deletaGrupo(id, token) {
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


function Grupoeditar(id) {
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

        var nome_grupo = document.getElementById('nome_grupo' + id).value
        var token = document.getElementById('token' + id).value


        var form_data = new FormData();

        form_data.append("nome_grupo", nome_grupo);
        form_data.append("grupo_id", id);
        form_data.append("token", token);



        $.ajax({
            url: "/createGrupo",
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

                    if (Boolean(data.nome_grupo)) {
                        document.getElementById('erronome' + id).innerHTML = `<span  class="text-danger" d-block >${data.nome_grupo}</span> `
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

function getGrupo(page) {

    document.getElementById('grupos').innerHTML = `<div id='contactos' class="text-center">
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
        url: '/getGrupos',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        if (Boolean(msg.erro)) {
            errorActivete('verifica a sua ligação')
            document.getElementById('grupos').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }
        document.getElementById('grupos').innerHTML = msg
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
