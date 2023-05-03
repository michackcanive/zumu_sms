(function ($) {

    "use strict";

    $("form.mf_form_validate").each(function () {
        $(this).validate({
            rules: {
                nome_sistema: {
                    required: true,
                },
                qtd_sender_grats: {
                    required: true,
                },
                date_existencia: {
                    required: true,
                },
                contacto: {
                    required: true,
                },
                localizacao: {
                    required: true,
                },
                dica_sistema: {
                    required: true,
                },
                qtd_kz_sender: {
                    required: true,
                },
                email: {
                    required: true,
                },
                nif: {
                    required: true,
                },
                endereco: {
                    required: true
                },
                hora_atendimento: {
                    required: true
                },
                hora_atendimento_termino: {
                    required: true
                },
                objectivo_sistema: {
                    required: true
                },
                beneficiario: {
                    required: true,
                },
                iban: {
                    required: true,
                }


            },
            messages: {
                nome_sistema: {
                    required: "Nome Sistema",
                },
                qtd_sender_grats: {
                    required: "Forneça a quantidade de sender id grátis",
                },
                contacto: {
                    required: "Contacto do sistema",
                },
                localizacao: {
                    required: "Localização da sistema",
                },
                dica_sistema: {
                    required: " Dica do sistema",
                },
                email: {
                    required: "Informa o email",
                },
                nif: {
                    required: "Informe seu nif"
                }
                ,
                endereco: {
                    required: "Informe seu endereço"
                },
                hora_atendimento: {
                    required: "Hora de atendimento"
                },
                hora_atendimento_termino: {
                    required: "Hora de termino do serviço"
                },
                objectivo_sistema: {
                    required: "Objectivos social"
                },
                qtd_kz_sender: {
                    required: "Forneça o um valor do sender id a cobrar",
                },
                beneficiario: {
                    required: "Forneça o nome do Beneficiário ",
                },
                iban: {
                    required: "Forneça suas IBAN ",
                }

                

            },
        });
    });

    $("form.ajax_submit").on('submit', function (e) {
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
            form_message = form.find('textarea'),
            server_result_display = form.find('.server_response');


        form_fields.each(function () {
            if ($(this).hasClass('error')) {
                has_errors = true;
            }
        });

        if (form_message.length > 0) {
            if (form_message.hasClass('error')) {
                has_errors = true;
            }
        }


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

                    if (data.erro === true) {

                        console.log(data)
                        Toast.fire({
                            icon: 'info',
                            title: `${data.mensagem ?? 'acção não esperda !'} `
                        })
                        document.getElementById('register').innerHTML = `Gravar`;
                        document.getElementById('register').disabled = false;
                        return;
                    }
                    if (data.erro === false) {
                        console.log(data)
                        $('#modal-default').modal('hide')
                        sucessoCarregdo('GRAVADO')
                        document.getElementById('register').innerHTML = `Gravar`;
                        document.getElementById('register').disabled = false;
                        setTimeout(function () { window.location.reload(); }, 2000);

                        /* setTimeout(function () {
                            $('form.ajax_submit .mf_alert').fadeOut(500);
                        }, 1500); */
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
        `Erro ao ${tipo_de_activacao}`,
        `erro ao ${tipo_de_activacao} a igreja `,
        'warning',
    )
}



function configeditar(id, id_igreja) {
    $(document).ready(function () {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        document.getElementById('register' + id).innerHTML = `<div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>`;
        document.getElementById('register' + id).disabled = true;

        var nome_obreiro = document.getElementById('nome_obreiro' + id).value
        var tipo_para_qual_igreja = document.getElementById('tipo_para_qual_igreja' + id).value
        var descricao_obreiro = document.getElementById('descricao_obreiro' + id).value
        var token = document.getElementById('token' + id).value

        var foto_obreiro = document.getElementById('foto_obreiro' + id).files[0] ?? '';

        var form_data = new FormData();
        form_data.append("foto_obreiro", foto_obreiro);
        form_data.append("id", id);
        form_data.append("nome_obreiro", nome_obreiro);
        form_data.append("descricao_obreiro", descricao_obreiro);
        form_data.append("token", token);
        form_data.append("tipo_para_qual_igreja", tipo_para_qual_igreja);



        $.ajax({
            url: "/creteObreiros",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                //$("#preview").fadeOut();

                $("#err").fadeOut();
            },
            success: function (msg) {
                console.log(msg)
                if (!msg.erro) {

                    console.log(msg)
                    Toast.fire({
                        icon: 'success',
                        title: `${msg.mensagem} `
                    })

                    setTimeout(function () { window.location.reload(); }, 2000);
                }
                else {

                    Toast.fire({
                        icon: 'info',
                        title: `${msg.mensagem} 😓`
                    })
                    document.getElementById('register' + id).innerHTML = `EDITAR`;
                    document.getElementById('register' + id).disabled = false;
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
