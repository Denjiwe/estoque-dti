$('#campo').on('change', function() {
    var valor = $(this).val();

    switch (valor) {
        case 'id':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="id" type="number" min="1" placeholder="Informe o ID" class="form-control" required>');

            var label = $('<label for="id">ID</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'solicitacao':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="solicitacao" type="number" min="1" placeholder="Informe o código" class="form-control" required>');

            var label = $('<label for="solicitacao">Código da Solicitação</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'interno':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="interno" type="text" placeholder="Insira o nome" class="form-control" required>');

            var label = $('<label for="interno">Nome do Usuário Interno</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'solicitante':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="solicitante" type="text" placeholder="Insira o nome" class="form-control" required>');

            var label = $('<label for="interno">Nome do Usuário Solicitante</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'diretoria':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="diretoria" type="text" placeholder="Insira o nome da diretoria" class="form-control" required>');

            var label = $('<label for="diretoria">Nome da Diretoria</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'divisao':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="divisao" type="text" placeholder="Insira o nome da divisão" class="form-control" required>');

            var label = $('<label for="divisao">Nome da Divisão</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'produto':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="produto" type="text" placeholder="Insira o nome do produto" class="form-control" required>');

            var label = $('<label for="produto">Nome da Produto</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'created_at':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-2')) {
                $('#pesquisa').removeClass('col-2').addClass('col-6');
            }

            var div = $('<div>').attr('class', 'row');

            var dataInicio = $('<div class="col-6"><input name="data_criacao_inicio" type="date" class="form-control" required></div>');

            var dataFim = $('<div class="col-6"><input name="data_criacao_fim" type="date" class="form-control"></div>');

            var label = $('<label for="id">Data de criação</label>');

            pesquisaDiv.append(label);
            div.append(dataInicio);
            div.append(dataFim);
            pesquisaDiv.append(div);

            break;
    }
});