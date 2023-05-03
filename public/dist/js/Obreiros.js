(function ($) {

    "use strict";

    $("form.mf_form_validate_obr").each(function () {
        $(this).validate({
            rules: {
                nome_sender: {
                    required: true,
                }
            },
            messages: {
                nome_sender: {
                    required: "Nome do Sender a Criar",
                }
            },
        });
    });

    $("form.ajax_submit_obr").on('submit', function (e) {
        e.preventDefault();

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var has_errors = false,
            form = $(this),
            form_fields = form.find('input');
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
                    console.log(data)
                    if (data.erro === true || data.erro != false) {

                        console.log(data)
                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem ?? 'acção não esperda !'} `
                        })

                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }

                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Criação de Sender')
                        getSender()
                        document.getElementById('register').innerHTML = `Enviar`;
                        document.getElementById('register').disabled = false;
                        form.trigger("reset");
                    }
                },


                error: function (data) {
                    console.log(data.responseText)

                    Toast.fire({
                        icon: 'warnnig',
                        title: `${data.responseText} `
                    })
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

function deletaobreiro(id, token) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    document.getElementById('delete' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('delete' + id).disabled = true;
    //var token = document.getElementById('token'+id).value;

    data = {
        id_sender: id,
        token: token
    }

    $.ajax({
        url: '/deletaobreiro',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {

        if (msg.erro == false) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} `
            })
            getSender()
        } else {
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem}!`
            })

        }
        document.getElementById('delete' + id).disabled = false;
        document.getElementById('delete' + id).innerHTML = '<i class="fas fa-trash"></i>'

    }).fail(function (data) {
        console.log(data.responseText)

        Toast.fire({
            icon: 'info',
            title: `Acção inesperada`
        })
        document.getElementById('delete' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
        document.getElementById('delete' + id).disabled = false;
        document.getElementById('delete' + id).innerHTML = '<i class="fas fa-trash"></i>'

    })


}

function processarSender(id, token) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    document.getElementById('process_sender' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
    document.getElementById('process_sender' + id).disabled = true;
    //var token = document.getElementById('token'+id).value;

    data = {
        id_sender: id,
        token: token
    }

    $.ajax({
        url: '/processarsenderID',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
    
        if (msg.erro == false) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} `
            })
            getSender()
        } else {
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem}!`
            })

        }
        document.getElementById('process_sender' + id).disabled = false;
        document.getElementById('process_sender' + id).innerHTML = '<i class="nav-icon fas fa-check"></i>'

    }).fail(function (data) {
        console.log(data.responseText)

        Toast.fire({
            icon: 'info',
            title: `Acção inesperada`
        })
        document.getElementById('process_sender' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
        document.getElementById('process_sender' + id).disabled = false;
        document.getElementById('process_sender' + id).innerHTML = '<i class="nav-icon fas fa-check"></i>'

    })


}


function getSender(page) {
document.getElementById('sender').innerHTML = `<div id='sender' class="text-center">
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
        url: '/getSender',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        if(Boolean(msg.erro)){
            errorActivete('verifica a sua ligação')
            document.getElementById('sender').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('pendenteValue').innerHTML = `0`
            document.getElementById('activeValue').innerHTML = `0`
            return;
        }
        document.getElementById('sender').innerHTML = msg
        reniciarTabela()
        let activeValue = document.getElementById('activado').value
        let totalPendente = document.getElementById('pendente').value
        let total_sender = document.getElementById('total_sender').value
        let total_sender_gratis = document.getElementById('total_sender_gratis').value

        document.getElementById('activeValue').innerHTML = `${activeValue}`
        document.getElementById('pendenteValue').innerHTML = `${totalPendente}`

        if (parseInt(total_sender) > parseInt(total_sender_gratis))
            $('#pagar_sender').removeClass('d-none')

    }).fail(function (data) {
        errorActivete('Não foi possível obter os dados')
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
