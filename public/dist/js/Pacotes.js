(function ($) {

    "use strict";

    $("form.mf_form_validate_membro").each(function () {
        $(this).validate({
            rules: {
                nomepacote: {
                    required: true,
                },
                qtduser: {
                    required: true
                },
                qtd_sms_user: {
                    required: true,
                    integer: true
                },
                text_ideal: {
                    required: true
                }
            },
            messages: {
                nomepacote: {
                    required: "NOME DO PACOTE "
                },
                qtduser: {
                    required: "QUANTA A REVENDER"
                },
                qtd_sms_user: {
                    required: "QUANTA DA SMS PARA O PACOTE",
                    integer: "FORNEÇA UM VALOR VALIDO"
                },
                text_ideal: {
                    required: "QUANTA A REVENDER"
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
            document.getElementById('register').innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
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

                        if (Boolean(data.nomepacote)) {
                            document.getElementById('erronomepacote_pacote').innerHTML = `<span  class="text-danger" d-block >${data.nomepacote}</span> `

                        } else {
                            document.getElementById('erronomepacote_pacote').innerHTML = ``
                        }

                        if (Boolean(data.qtduse)) {
                            document.getElementById('erroqtduser_pacote').innerHTML = `<span  class="text-danger" d-block >${data.qtduse}</span> `
                        } else {
                            document.getElementById('erroqtduser_pacote').innerHTML = ``
                        }


                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Criação de Pacote')
                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        getPacotes()
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
        `Uups ${tipo_de_activacao}`,
        `${tipo_de_activacao}  `,
        'warning',
    )
}

function getPacotes(page) {

    document.getElementById('pacote').innerHTML = `<div id='sender' class="text-center">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
</div>`
    var token = document.querySelector('#token').value;
    dados = {
        token: token,
        page: page ?? ''
    }
    $.ajax({
        url: '/getPacotes',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        if(Boolean(msg.erro)){
            errorActivete('verifica a sua ligação')
            document.getElementById('pacote').innerHTML = ''
            document.getElementById('pacoteSmsMostrar').innerHTML = `0`
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }
        document.getElementById('pacote').innerHTML = msg
        reniciarTabela()
        let activeValue = document.getElementById('activadoSMS').value
        let pacoteSms = document.getElementById('pacoteSms').value
        //'pacoteSistema' => $this->configuracaos->one_sms_sistem,
        document.getElementById('pacoteSmsMostrar').innerHTML = `${pacoteSms}`
        document.getElementById('activeValue').innerHTML = `${activeValue}`


    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        console.log(data.responseText)
    })
}

function getPacotescliente(page) {

    document.getElementById('pacote').innerHTML = `<div id='sender' class="text-center">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
</div>`
    var token = document.querySelector('#token').value;
    dados = {
        token: token,
        page: page ?? ''
    }
    $.ajax({
        url: '/getPacotes',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        document.getElementById('pacote').innerHTML = msg
        reniciarTabela()

    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        console.log(data.responseText)
    })
}


function deletpacotes(id, token) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    document.getElementById('delete' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('delete' + id).disabled = true;
    var token = document.getElementById('token'+id).value;

    data = {
        id_pacote: id,
        token: token
    }

    $.ajax({
        url: '/deletapacotes',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)
        if (!msg.erro) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} `
            })
            getPacotes();
            document.getElementById('delete' + id).innerHTML = 'deletar'
            document.getElementById('delete' + id).disabled = false;
    
        } else {
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem}!`
            })
            document.getElementById('delete' + id).innerHTML = 'deletar'
            document.getElementById('delete' + id).disabled = false;

        }


    }).fail(function (data) {
        Toast.fire({
            icon: 'info',
            title: `Acção inesperada`
        })
        console.log(data.responseText)
        document.getElementById('delete' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
        document.getElementById('delete' + id).disabled = false;
        document.getElementById('delete' + id).innerHTML = 'deletar'

    })


}


function pacoteseditar(id) {
    $(document).ready(function () {

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        document.getElementById('register' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
        document.getElementById('register' + id).disabled = true;

        var nomepacote = document.getElementById('nomepacote' + id).value
        var qtduser = document.getElementById('qtduser' + id).value
        var qtd_sms_user = document.getElementById('qtd_sms_user' + id).value
        var text_ideal = document.getElementById('text_ideal' + id).value
        var token = document.getElementById('token' + id).value


        var form_data = new FormData();

        form_data.append("nomepacote", nomepacote);
        form_data.append("qtduser", qtduser);
        form_data.append("qtd_sms_user", qtd_sms_user);
        form_data.append("text_ideal", text_ideal);
        form_data.append("id_pacote", id);
        form_data.append("token", token)



        $.ajax({
            url: "/cretepacotes",
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
                    getPacotes()

                }
                else {

                    Toast.fire({
                        icon: 'info',
                        title: `${data.mensagem}`
                    })
                    document.getElementById('register' + id).innerHTML = `EDITAR`;
                    document.getElementById('register' + id).disabled = false;

                    if (Boolean(data.email_membro)) {
                        document.getElementById('erronomepacote' + id).innerHTML = `<span  class="text-danger" d-block >${data.nomepacote}</span> `

                    } else {
                        document.getElementById('erronomepacote' + id).innerHTML = ``
                    }

                    if (Boolean(data.telefone)) {
                        document.getElementById('erroqtduser' + id).innerHTML = `<span  class="text-danger" d-block >${data.qtduser}</span> `
                    } else {
                        document.getElementById('erroqtduser' + id).innerHTML = ``
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

function activarpacoteprocess(id) {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    let btnactive = document.getElementById('btnactive' + id);
    let token = document.querySelector('#token').value;

    dados = {
        token: token,
        id_pacote: id,
    }

    btnactive.innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('btnactive' + id)

    $.ajax({
        url: '/comprarsms',
        type: 'post',
        data: dados,
        timeout: 30000,

    }).done(function (msg) {

        if (msg.erro == true) {
            console.log(msg)
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem} `
            })

            btnactive.innerHTML = `COMPRAR SMS`;
            btnactive.disabled = false;

            return;
        }

        if (msg.erro === false) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} , `
            })
            setTimeout(function () { depoiscompra(); }, 1000);

        }
        btnactive.innerHTML = `COMPRAR SMS`;
        btnactive.disabled = false;

    }).fail(function (data) {
        console.log(data.responseText)

        Toast.fire({
            icon: 'info',
            title: `${'Não foi possível'} `
        })
        document.getElementById('btnactive' + id).disabled = false;
    })
}

function comprapacote(id) {

    //const nome_inter=document.querySelector('#nome_inter').value;
    //aceitar(id,numero);

    Swal.fire({
        title: 'COMPRAR DE SMS',
        icon: 'info',
        text: `POCOTE DE MENSAGEM`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SIM',

    }).then((result) => {
        if (result.isConfirmed) {
            activarpacoteprocess(id)
            //window.location.href = "/my_gestao_sms"
        } else {
            //  alert('Não será possivel enviar por SMS')
        }

    })

}

function depoiscompra() {

    //const nome_inter=document.querySelector('#nome_inter').value;
    //aceitar(id,numero);

    Swal.fire({
        title: 'COMEÇAR AGORA',
        icon: 'info',
        text: `MENSAGEM EM MARKETING`,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: ' SIM ',

    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/my_send_sms"
        } else {
            //  alert('Não será possivel enviar por SMS')
        }

    })

}

function getPacotesSite(page) {

    document.getElementById('pacote').innerHTML = `<div id='sender' class="text-center">
    <div class="d-flex justify-content-center">
        <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
            <span class="visually-hidden"></span>
        </div>
    </div>
</div>`
    var token = document.querySelector('#token').value;
    dados = {
        token: token,
        page: page ?? ''
    }
    $.ajax({
        url: '/getPacotesSite',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        console.log(msg)

        document.getElementById('pacote').innerHTML = msg

    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
        console.log(data.responseText)
    })
}
