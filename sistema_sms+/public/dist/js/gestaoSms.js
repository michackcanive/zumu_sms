(function ($) {

    "use strict";

    $("form.mf_form_validate_membro").each(function () {
        $(this).validate({
            rules: {
                quantia_de_sms: {
                    required: true,
                },
                typeopercao: {
                    required: true
                },
                email_user: {
                    required: true,
                    email: true
                }
            },
            messages: {
                quantia_de_sms: {
                    required: "Quantidade de sms para operar"
                },
                typeopercao: {
                    required: "Tipo de operação"
                },
                email_user: {
                    required: "Cliente destinatario"
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
            form_fieldsselect = form.find('select'),
            form_fields = form.find('input'),

            server_result_display = form.find('.server_response');

        form_fields.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });
        form_fieldsselect.each(function () {
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
                    console.log(data)
                    if (data.erro === true) {
                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem} `
                        })

                        if (Boolean(data.email_user)) {
                            document.getElementById('erroemail_user_pacote').innerHTML = `<span  class="text-danger" d-block >${data.email_user}</span> `

                        } else {
                            document.getElementById('erroemail_user_pacote').innerHTML = ``
                        }
                        if (Boolean(data.quantia_de_sms)) {
                            document.getElementById('erroquantia_de_sms_pacote').innerHTML = `<span  class="text-danger" d-block >${data.quantia_de_sms}</span> `
                        } else {
                            document.getElementById('erroquantia_de_sms_pacote').innerHTML = ``
                        }

                        if (Boolean(data.typeopercao)) {
                            document.getElementById('errotypeopercao_pacote').innerHTML = `<span  class="text-danger" d-block >${data.typeopercao}</span> `
                        } else {
                            document.getElementById('errotypeopercao_pacote').innerHTML = ``
                        }
                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('OPERAÇÃO FEITA')
                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        getOperation()
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
        `${tipo_de_activacao}  `,
        'warning',
    )
}

function getOperation(page) {

    document.getElementById('Operation').innerHTML = `<div id='sender'>
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
        pesquisar:pesquisar??''
    }
    $.ajax({
        url: '/getOperation',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)
        if(Boolean(msg.erro)){
            errorActivete('verifica a sua ligação')
            document.getElementById('Operation').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('restantesSmsMostrar').innerHTML = `0`
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }

        document.getElementById('Operation').innerHTML = msg
        reniciarTabela()
        document.getElementById('buscar').disabled = false;
        let activeValue = document.getElementById('activadoSMS').value
        let restantesSMS = document.getElementById('restantesSMS').value
        document.getElementById('restantesSmsMostrar').innerHTML = `${restantesSMS}`
        document.getElementById('activeValue').innerHTML = `${activeValue}`


    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        document.getElementById('buscar').disabled = false;
    })
}


function getOperationvenda(page) {

    document.getElementById('Operation').innerHTML = `<div id='sender'>
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
        pesquisar:pesquisar??''
    }
    $.ajax({
        url: '/getOperationvenda',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)

        if(Boolean(msg.erro)){
            errorActivete('verifica a sua ligação')
            document.getElementById('Operation').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('total_de_venda_sms').innerHTML = `0`
            document.getElementById('total_sms_venda_sms').innerHTML = `0`
            return;
        }

        document.getElementById('Operation').innerHTML = msg
        reniciarTabela()
        document.getElementById('buscar').disabled = false;
        let activeValue = document.getElementById('total_de_venda').value
        let restantesSMS = document.getElementById('total_sms_venda').value
        document.getElementById('total_de_venda_sms').innerHTML = `${restantesSMS}`
        document.getElementById('total_sms_venda_sms').innerHTML = `${activeValue}`


    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        document.getElementById('buscar').disabled = false;
    })
}

//getCompras_sms

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
