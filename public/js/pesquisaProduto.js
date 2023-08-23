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
        case 'modelo':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="modelo" type="text" placeholder="Insira o modelo do produto" class="form-control" required>');

            var label = $('<label for="id">Nome</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'tipo':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var select = $('<select>').attr('class', 'form-select');
            select.attr('name', 'tipo');

            select.append(new Option('Impressora', 'IMPRESSORA'));
            select.append(new Option('Toner', 'TONER'));
            select.append(new Option('Cilindro', 'CILINDRO'));
            select.append(new Option('Outros', 'OUTROS'));
            
            var label = $('<label for="id">Status</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(select);
            break;
        case 'quantidade':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var newInput = $('<input name="quantidade" type="number" min="0" placeholder="Quantidade em estoque" class="form-control" required>');

            var label = $('<label for="quantidade">Quantidade</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(newInput);
            break;
        case 'status':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-6')) {
                $('#pesquisa').removeClass('col-6').addClass('col-2');
            }

            var select = $('<select>').attr('class', 'form-select');
            select.attr('name', 'status');

            select.append(new Option('Ativo', 'ATIVO'));
            select.append(new Option('Inativo', 'INATIVO'));
            
            var label = $('<label for="id">Status</label>');

            pesquisaDiv.append(label);
            pesquisaDiv.append(select);
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
        case 'updated_at':
            $('#pesquisa').empty();
            var pesquisaDiv = $('#pesquisa');

            if($('#pesquisa').hasClass('col-2')) {
                $('#pesquisa').removeClass('col-2').addClass('col-6');
            }

            var div = $('<div>').attr('class', 'row');

            var dataInicio = $('<div class="col-6"><input name="data_edicao_inicio" type="date" class="form-control" required></div>');

            var dataFim = $('<div class="col-6"><input name="data_edicao_fim" type="date" class="form-control"></div>');

            var label = $('<label for="id">Data de edição</label>');

            pesquisaDiv.append(label);
            div.append(dataInicio);
            div.append(dataFim);
            pesquisaDiv.append(div);

            break;
    }
});