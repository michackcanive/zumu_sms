(function ($) {

    "use strict";

    $("form.mf_form_validate_carregamento").each(function () {
        $(this).validate({
            rules: {
                comprovativo: {
                    required: true,
                },
                amount_kz: {
                    required: true,

                }, nota: {
                    required: true
                }
            },
            messages: {
                comprovativo: {
                    required: "FORNEÇA O COMPROVATIVO",
                },
                amount_kz: {
                    required: "FORNEÇA O VALOR TRANSFERIDO (AKz)",
                },
                nota: {
                    required: "FORNEÇA UMA NOTA",
                }
            },
        });
    });

    $("form.ajax_submit_carregamento").on('submit', function (e) {
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
            document.getElementById('createpedido').innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
            document.getElementById('createpedido').disabled = true;

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
                    if (data.erro == true) {

                        console.log(data)

                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem ?? 'acção não esperda !'} `
                        })
                        /*         alert('acção não esperda !') */
                        document.getElementById('createpedido').innerHTML = `criar`;
                        document.getElementById('createpedido').disabled = false;
                        return;
                    }

                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('Operação feita')
                        document.getElementById('createpedido').innerHTML = `criar`;
                        document.getElementById('createpedido').disabled = false;
                        setTimeout(function () { window.location.reload(); }, 2000);
                        form.trigger("reset");
                    }
                },

                error: function (data) {
                    console.log(data.responseText)
                    Toast.fire({
                        icon: 'info',
                        title: `${data.responseText} `
                    })

                }
            });
        }

        return false;
    });
})(jQuery);

function getCarregamento(page) {

    document.getElementById('carregamento').innerHTML = `<div id='carregamento'>
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
        url: '/getsolicitacao_carregamentos',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {

        if(Boolean(msg.erro)){
            errorActivete('verifica a sua ligação')
            document.getElementById('carregamento').innerHTML = ''
            document.getElementById('buscar').disabled = false;
            document.getElementById('pendentes_Value').innerHTML = `0`
            document.getElementById('activados_Value').innerHTML = `0`
            document.getElementById('saldo_kz').innerHTML = `0`
            return;
        }

        document.getElementById('carregamento').innerHTML = msg
        let carrega_pendetes = document.getElementById('carrega_pendetes').value
        document.getElementById('pendentes_Value').innerHTML = `${carrega_pendetes}`

        let saldo_account_kz = document.getElementById('saldo_account_kz').value
        document.getElementById('saldo_kz').innerHTML = `${saldo_account_kz}`

        let carrega_activados = document.getElementById('carrega_activados').value
        document.getElementById('activados_Value').innerHTML = `${carrega_activados}`
        reniciarTabela()
        document.getElementById('buscar').disabled = false;


    }).fail(function (data) {
        console.log(data.responseText)
        errorActivete('Não foi possível obter os dados')
        document.getElementById('buscar').disabled = false;

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


function activarpacoteprocess(id) {

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    let btnactive = document.getElementById('btnactive' + id);

    let btnactivemodel = document.getElementById('btnactivemodel' + id)


    let token = document.querySelector('#token').value;
    let password = document.querySelector('#password' + id).value;
    if (password == '') {

        Toast.fire({
            icon: 'info',
            title: `FORNEÇA A SUA SENHA`
        })
        return
    }

    dados = {
        token: token,
        id_request: id,
        password: password
    }

    btnactivemodel.innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
    btnactivemodel.innerHTML = `<div class="spinner-border text-dark" style="width: 18px; height: 18px;" role="status">
    <span class="visually-hidden"></span>`;
    document.getElementById('btnactive' + id)
    document.getElementById('btnactivemodel' + id)

    $.ajax({
        url: '/activarcarregamento',
        type: 'post',
        data: dados,
        timeout: 30000,

    }).done(function (msg) {

        if (msg.erro == true) {
            console.log(msg)

            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem ?? 'acção não esperda !'} `
            })

            btnactive.innerHTML = `Activar`;
            btnactivemodel.innerHTML = `Activar`;
            btnactivemodel.disabled = false;
            btnactive.disabled = false;

            return;
        }

        if (msg.erro === false) {
            Toast.fire({
                icon: 'success',
                title: `${msg.mensagem} `
            })
            //setTimeout(function () { window.location.reload(); }, 2000);
            $('#modal-default' + id).modal('hide')
            getCarregamento()
        }

    }).fail(function (data) {
        console.log(data.responseText)

        Toast.fire({
            icon: 'info',
            title: `${'Não foi possível'} `
        })
        document.getElementById('btnactive' + id).disabled = false;
    })
}

function activarpacote(id) {

    //const nome_inter=document.querySelector('#nome_inter').value;
    //aceitar(id,numero);

    Swal.fire({
        title: 'ACTIVAR CARREGAMETO',
        icon: 'info',
        text: `ATENÇÃO `,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'SIM',

    }).then((result) => {
        if (result.isConfirmed) {
            // alert('ACEITO')
            $('#modal-default' + id).modal('toggle');
            // activarpacoteprocess(id)
            //window.location.href = "/my_gestao_sms"
        } else {
            //  alert('Não será possivel enviar por SMS')
        }

    })

}

function errorActivete(tipo_de_activacao) {
    Swal.fire(
        `${tipo_de_activacao}`,
        `${tipo_de_activacao}  `,
        'warning',
    )
}

