
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
        url: '/get_agendas',
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

