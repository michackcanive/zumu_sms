function selectIgreja(thisnum) {
    var token = document.querySelector('#token').value;
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    if (thisnum.value === '') {
        Toast.fire({
            icon: 'info',
            title: `${'SELECIONE UMA '} `
        })
        document.getElementById('id_membro').disabled = true;
        return;
    }

    data = {
        token: token,
        id_igreja: thisnum.value
    }

    $.ajax({
        url: '/get_by_membros',
        type: 'post',
        data: data,
        dataType: 'json',
        timeout: 40000,

    }).done(function (msg) {
        if (!msg.erro) {
            //reniciarTabela()
            document.getElementById('id_membro').disabled = false;
            console.log(msg)
            let dadosElento=''
            msg.data.forEach(element => {
                console.log(element)
                dadosElento = dadosElento + `<option value="${element.id}">${element.nome_membro}</option>`
            });
            document.getElementById('id_membro').innerHTML = dadosElento;
        } else {
            Toast.fire({
                icon: 'info',
                title: `${msg.mensagem} `
            })
            console.log(msg)
            document.getElementById('id_membro').disabled = true;
        }
    }).fail(function (data) {

    })


}
