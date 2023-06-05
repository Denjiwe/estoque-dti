$(document).ready(function() {
    var url = 'http://localhost:8000/api/';

    

    async function criaTrToner(impressoraId, impressoraModelo, quantidade) {
        var row = $('<tr>');
        var impressoraTd = $('<td>').text(impressoraModelo);
        row.append(impressoraTd);

        urlP = url+'toner-por-impressora/'+impressoraId;

        await fetch(urlP,{
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response=>response.json())
            .then(data => {
                var tonerId = data.id;
                var modeloToner = data.modelo_produto;

                var tonerTd = $('<td>').text(modeloToner);
                tonerTd.append(`<input style="display:none;" value="${tonerId}" name="produto[]">`)
                row.append(tonerTd);
            })
            .catch(data => console.log(data))
        
        var quantidadeTd = $('<td>').text(quantidade);
        quantidadeTd.append(`<input style="display:none;" value="${quantidade}" name="quantidade[]">`)
        row.append(quantidadeTd);

        var excluirBtn = $('<td>');
        excluirBtn.append($('<button>').text('Excluir').addClass('btn btn-danger remover'));
        row.append(excluirBtn);

        $('#tbody').append(row);
    }

    async function criaTrCilindro(impressoraId, impressoraModelo, quantidade) {
        var row = $('<tr>');
        var impressoraTd = $('<td>').text(impressoraModelo);
        row.append(impressoraTd);

        urlP = url+'cilindro-por-impressora/'+impressoraId;

        await fetch(urlP,{
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response=>response.json())
            .then(data => {
                var cilindroId = data.id;
                var modeloCilindro = data.modelo_produto;

                var cilindroTd = $('<td>').text(modeloCilindro);
                cilindroTd.append(`<input style="display:none;" value="${cilindroId}" name="produto[]">`)
                row.append(cilindroTd);
            });
        
        var quantidadeTd = $('<td>').text(quantidade);
        quantidadeTd.append(`<input style="display:none;" value="${quantidade}" name="quantidade[]">`)
        row.append(quantidadeTd);

        var excluirBtn = $('<td>');
        excluirBtn.append($('<button>').text('Excluir').addClass('btn btn-danger remover'));
        row.append(excluirBtn);

        $('#tbody').append(row);
    }

    $('#adicionar').click(function() {
        var tipoProduto = $('#suprimento').val();
        var impressoraId = $('#impressora').val();
        var impressoraModelo = $('#impressora').find(':selected').text();
        var quantidade = $('#quantidade').val();

        switch(tipoProduto){
            case 'TONER':
                    criaTrToner(impressoraId, impressoraModelo, quantidade);
                break;
            case 'CILINDRO':
                    criaTrCilindro(impressoraId, impressoraModelo, quantidade);
                break;
            case 'CONJUNTO':
                    criaTrToner(impressoraId, impressoraModelo, quantidade);
                    criaTrCilindro(impressoraId, impressoraModelo, quantidade);
                break;
        }

        $('#impressora').val('0');
        $('#suprimento').val('0');
        $('#quantidade').val('');
    });

    $(document).on('click', '.remover',function(e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });
});