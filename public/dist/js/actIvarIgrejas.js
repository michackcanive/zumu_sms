
function solicitacao_sms(id, nome_igreja,tipo_de_activacao) {

    Swal.fire({
        title: 'Tens Acerteza ?',
        text: `Prentendes Activar esta Igrejas ${nome_igreja}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `${tipo_de_activacao}`,

    }).then((result) => {

        if (result.isConfirmed) {
            var result = iniciar_solicitacao(id,tipo_de_activacao)
        }

    })
}

function iniciar_solicitacao(id,tipo_de_activacao) {

    if(tipo_de_activacao=='Activar'){
        document.getElementById("activar" + id).innerHTML = 'Activando...';
    }else{
        document.getElementById("desativar" + id).innerHTML = 'Desativando...';
    }

    dados = {
        id_igrejas: id,
        tipo_de_activacao:tipo_de_activacao
    }

    $.ajax({
        url: '/actvarigrejas',
        type: 'post',
        data: dados,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {
            sucessoCarregdo(tipo_de_activacao)
            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Activado...';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Desativado';
            }

            setTimeout(function () { window.location.reload(); }, 2000);
        } else {
            errorActivete(tipo_de_activacao)

            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Activar';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Desativar';
            }
        }
    }).fail(function (data) {
        console.log(data.responseText)
    });

}

function sucessoCarregdo(tipo_de_activacao) {
    Swal.fire(
        ` ${tipo_de_activacao} igreja`,
        `Sucesso ao ${tipo_de_activacao}`,
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



function solicitacao_public(id, nome_igreja,tipo_de_activacao) {

    Swal.fire({
        title: 'Tens Acerteza ?',
        text: `Prentendes Activar publicidade para: Igreja ${nome_igreja}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `${tipo_de_activacao}`,

    }).then((result) => {

        if (result.isConfirmed) {
            var result = iniciar_solicitacao_public(id,tipo_de_activacao)
        }

    })
}

function iniciar_solicitacao_public(id,tipo_de_activacao) {

    if(tipo_de_activacao=='Activar'){
        document.getElementById("activar" + id).innerHTML = 'publicitando...';
    }else{
        document.getElementById("desativar" + id).innerHTML = 'Desativando...';
    }

    dados = {
        id_igrejas: id,
        tipo_de_activacao:tipo_de_activacao
    }

    $.ajax({
        url: '/actvarigreja_public',
        type: 'post',
        data: dados,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {
            sucessoCarregdo(tipo_de_activacao)
            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Publicitado';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Desativado';
            }

            setTimeout(function () { window.location.reload(); }, 2000);
        } else {
            errorActivete(tipo_de_activacao)

            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Publicitar';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Desativar';
            }
        }
    }).fail(function (data) {
        console.log(data.responseText)
    });

}

function sucessoCarregdo(tipo_de_activacao) {
    Swal.fire(
        ` ${tipo_de_activacao} igreja`,
        `Sucesso ao ${tipo_de_activacao}`,
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




function solicitacao_public_pedido(id, nome_igreja,tipo_de_activacao) {

    Swal.fire({
        title: 'Tens Acerteza ?',
        text: `Prentendes solicitar publicidade na Igreja ${nome_igreja}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `${tipo_de_activacao}`,

    }).then((result) => {

        if (result.isConfirmed) {
            var result = iniciar_solicitacao_public_pedido(id,tipo_de_activacao)
        }

    })
}

function iniciar_solicitacao_public_pedido(id,tipo_de_activacao) {

    if(tipo_de_activacao=='Activar'){
        document.getElementById("activar" + id).innerHTML = 'Solicitando...';
    }else{
        document.getElementById("desativar" + id).innerHTML = 'Desfazendo...';
    }

    dados = {
        id_igrejas: id,
        tipo_de_activacao:tipo_de_activacao
    }

    $.ajax({
        url: '/actvarigreja_public_pedido',
        type: 'post',
        data: dados,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {
            sucessoCarregdo(tipo_de_activacao)
            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Publicitado';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Removido';
            }

            setTimeout(function () { window.location.reload(); }, 2000);
        } else {
            errorActivete(tipo_de_activacao)

            if(tipo_de_activacao=='Activar'){
                document.getElementById("activar" + id).innerHTML = 'Pedir Publicidade';
            }else{
                document.getElementById("desativar" + id).innerHTML = 'Desfazendo';
            }
        }
    }).fail(function (data) {
        console.log(data.responseText)
    });

}

function sucessoCarregdo(tipo_de_activacao) {
    Swal.fire(
        ` ${tipo_de_activacao} igreja`,
        `Sucesso ao ${tipo_de_activacao}`,
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


