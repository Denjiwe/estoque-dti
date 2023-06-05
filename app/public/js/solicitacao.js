$(document).ready(function() {
    var urlBase = 'http://localhost:8000/api/';
    var usuario = $('#usuario option:first');

    async function criaTrToner(impressoraId, impressoraModelo, quantidade) {
        var row = $('<tr>');
        var impressoraTd = $('<td>').text(impressoraModelo);
        row.append(impressoraTd);

        url = urlBase+'toner-por-impressora/'+impressoraId;

        await fetch(url,{
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

        url = urlBase+'cilindro-por-impressora/'+impressoraId;

        await fetch(url,{
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

    async function divisoes(diretoriaId){
        var selectDivisao = $('#divisao');
        var selectUsuario = $('#usuario');
        var usuarioSelecionadoId = selectUsuario.val();

        selectDivisao.prop('disabled', true);
        selectDivisao.empty();
        selectDivisao.append($('<option>').val('0').text('Nenhuma'));

        selectUsuario.prop('disabled', true);
        selectUsuario.empty();

        var loader = $('<div>').addClass('float-end').append($('<div>').addClass('spinner-border spinner-border-sm'));
        selectDivisao.after(loader);
        selectUsuario.after(loader);

        url = urlBase+'dados-por-diretoria/'+diretoriaId;

        await fetch(url,{
            method: 'GET',
            headers: {
                'Accept' : 'application/json'
            }
        })
            .then(response=>response.json())
            .then(data => {
                loader.remove();
                data[0].forEach(divisao => {
                    selectDivisao.append($('<option>').val(divisao.id).text(divisao.nome));
                });

                selectUsuario.append($(usuario));
                selectUsuario.append($('<option>').addClass('bg-body').prop('disabled', true).val('').text('-- Diretoria: '+$('#diretoria').find(':selected').text()+' --'));
                data[1].forEach(usuarioDiretoria => {
                    if(usuarioDiretoria.id != usuario.val()) {
                        selectUsuario.append($('<option>').val(usuarioDiretoria.id).text(usuarioDiretoria.nome));
                    }
                });

                selectUsuario.append($('<option>').addClass('bg-body').prop('disabled', true).val('').text('-- Todos --'));
                data[2].forEach(usuarioTodos => {
                    if(usuarioTodos.id != usuario.val()) {
                        selectUsuario.append($('<option>').val(usuarioTodos.id).text(usuarioTodos.nome));
                    }
                });

                selectUsuario.find(`option[value="${usuarioSelecionadoId}"]`).prop('selected', true);
                selectDivisao.prop('disabled', false);
                selectUsuario.prop('disabled', false);
            });
    }

    async function dadosPorUsuario(usuarioId){
        var selectDiretoria = $("#diretoria");
        var selectDivisao = $("#divisao");

        selectDiretoria.prop('disabled', true);
        selectDivisao.prop('disabled', true);
        selectDivisao.empty();
        selectDivisao.append($('<option>').val('0').text('Nenhuma'));


        url = urlBase+'dados-por-usuario/'+usuarioId

        await fetch(url,{
            method: 'GET',
            headers: {
                'Accept' : 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                selectDiretoria.find(`option[value="${data.diretoria_id}"]`).prop('selected', true);

                if(data.divisao_id != null) {
                    data.divisoes.forEach(divisao => {
                        if(data.divisao_id == divisao.id) {
                            selectDivisao.append($('<option>').val(divisao.id).text(divisao.nome).prop('selected', true));
                        } else {
                            selectDivisao.append($('<option>').val(divisao.id).text(divisao.nome));
                        }
                    })
                }

                selectDiretoria.prop('disabled', false);
                selectDivisao.prop('disabled', false);
            });
    }

    $('#diretoria').on('change', function(){
        var diretoriaId = $('#diretoria').val();
        divisoes(diretoriaId);
    });

    $('#usuario').on('change', function(){
        dadosPorUsuario($('#usuario').val());
    });

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