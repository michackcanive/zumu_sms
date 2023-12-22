(function ($) {

    "use strict";

    $("form.mf_form_validate_send").each(function () {
        $(this).validate({
            rules: {
                id_sender: {
                    required: true,
                },
                message_body: {
                    required: true
                },
                type_send: {
                    required: true,
                },
                number_phone: {
                    required: false,
                }
            },
            messages: {
                id_sender: {
                    required: "informe a aplicação"
                },
                message_body: {
                    required: "Infome o corpo da mensagem"
                },
                type_send: {
                    required: "Forneça o tipo de envio"
                },
                number_phone: {
                    required: "Cliente destinatario"
                }
            },
        });
    });

    $("form.ajax_submit_send").on('submit', function (e) {
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
            form_fieldstextarea = form.find('textarea'),
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

        form_fieldstextarea.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });

        var datastring = form.serialize();

        let tipoValue = document.getElementById('type_send').value

        if (tipoValue == 'individual') {
            let number_phone = document.getElementById('number_phone').value
            if (number_phone == '') {
                Toast.fire({
                    icon: 'warning',
                    title: `Forneça o contactos ... `
                })
                return;
            }
        } else if (tipoValue == 'Grupo') {
            let id_grupo = document.getElementById('id_grupo').value

            if (id_grupo == '') {
                Toast.fire({
                    icon: 'warning',
                    title: `Forneça o grupo `
                })
                return;
            }
        } else if (tipoValue == 'Massa') {
            let contactos = document.getElementById('contactos').value
            if (contactos == 0) {
                Toast.fire({
                    icon: 'warning',
                    title: `Sem contacto cadastrado `
                })
                return;
            }
        } else if (tipoValue == 'file') {
            let type_file = document.getElementById('type_file').value
            if (type_file == '') {
                Toast.fire({
                    icon: 'warning',
                    title: `Forneça o arquivo `
                })
                return;
            }
        } else if (tipoValue == '') {

            Toast.fire({
                icon: 'warning',
                title: `Forneça um tipo de envio `
            })
            return;
        }

        if (!has_errors) {
            // ispinnermodalsend
            //  d-none

            $('#ispinnermodalsend').removeClass('d-none')
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
                    $('#ispinnermodalsend').addClass('d-none')
                    console.log(data)
                    if (data.erro === true) {


                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem} `
                        })

                        if (Boolean(data.id_sender)) {
                            document.getElementById('erroid_sender').innerHTML = `<span  class="text-danger" d-block >${data.id_sender}</span> `

                        } else {
                            document.getElementById('erroid_sender').innerHTML = ``
                        }
                        if (Boolean(data.message_body)) {
                            document.getElementById('erromessage_body').innerHTML = `<span  class="text-danger" d-block >${data.message_body}</span> `
                        } else {
                            document.getElementById('erromessage_body').innerHTML = ``
                        }

                        if (Boolean(data.number_phone)) {
                            document.getElementById('erronumber_phone').innerHTML = `<span  class="text-danger" d-block >${data.number_phone}</span> `
                        } else {
                            document.getElementById('erronumber_phone').innerHTML = ``
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
                        $('#type_agendar').addClass('d-none')
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
                    $('#ispinnermodalsend').removeClass('d-none')
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

function getOperation(page) {

    document.getElementById('Operation').innerHTML = `<div id='sender' class="text-center">
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
        url: '/getSmsSend',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        //console.log(msg)

        if (Boolean(msg.erro)) {
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
function contactar_char_1(valor, divide) {

    var message = valor; // Sua mensagem aqui
    var characterCount = message.length;
    var smsCount = Math.ceil(characterCount / parseInt(divide)); // Arredonda para cima para obter o número de SMS necessárias

    var frase = "Esta é uma frase com palavras acentuadas.";
    var regex = /[áàâãéèêíïóôõöúç]/i;

    /*if (regex.test(frase)) {

      console.log("A frase contém palavras com acentuação.");
    } else {
      console.log("A frase não contém palavras com acentuação.");
    }*/

    document.getElementById("number_caractres").innerHTML = "Número de caracteres: " + characterCount;
    //document.getElementById("number_descontar").innerHTML = "Número de SMS: " + smsCount;
}


function getsender_Operation(page) {

    document.getElementById('id_sender').disabled = true;

    $.ajax({
        url: '/getsenderSend',
        type: 'post',
        data: dados,
        timeout: 40000,

    }).done(function (msg) {
        document.getElementById('id_sender').disabled = false;
        let dadosElento = ''
        msg.sender_id_active.forEach(element => {
            console.log(element)
            dadosElento = dadosElento + `<option value="${element.id}">${element.name_sender_id}</option>`
        });
        document.getElementById('id_sender').innerHTML = dadosElento;

    }).fail(function (data) {
        errorActivete('Não foi possível obter os Sender ID')
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

function is_agenda_f(tipoValue) {

    let agendar = document.getElementById('is_agenda');

    if (!agendar.checked) {
        $('#type_agendar').addClass('d-none')

    } else {
        $('#type_agendar').removeClass('d-none')
    }
}
