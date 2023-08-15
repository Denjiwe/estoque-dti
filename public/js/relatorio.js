var data = $('#data');
var campo = $('#campo');
if(data.val() == 'personalizado') {
    dataInicio = $('<div class="col-2"><label>Data de Inicio</label><input id="data_inicio" name="data_inicio" type="date" class="form-control" required></div>');
    dataFinal = $('<div class="col-2"><label>Data de Fim</label><input id="data_final" name="data_final" type="date" class="form-control" required></div>');
    var dataDiv = $('#dataDiv');
    dataFinal.insertAfter(dataDiv);
    dataInicio.insertAfter(dataDiv);
}

data.on('change', function() {
    if(data.val() == 'personalizado') {
        dataInicio = $('<div class="col-2"><label>Data de Inicio</label><input id="data_inicio" name="data_inicio" type="date" class="form-control" required></div>');
        dataFinal = $('<div class="col-2"><label>Data de Fim</label><input id="data_final" name="data_final" type="date" class="form-control" required></div>');
        var dataDiv = $('#dataDiv');
        dataFinal.insertAfter(dataDiv);
        dataInicio.insertAfter(dataDiv);
    } else {
        if ($('#data_inicio')) {
            $('#data_inicio').parent().remove();
            $('#data_final').parent().remove();
        }
    }
});

$(document).on('change', '#data_inicio', function() {
    $('#data_final').attr('min', $(this).val());
});

$(document).on('change', '#data_final', function() {
    $('#data_inicio').attr('max', $(this).val());
});

$(document).on('change', '#tipo', function() {
    if ($(this).val() == 'Solicitacao') {
        campo.append(new Option('Status', 'status'));
    } else if ($(this).val() != 'Solicitacao' && $('#campo').find('option[value="status"]').length) {
        $('#campo').find('option[value="status"]').remove();
    }
});

if(campo.val() != 'todos') {
    $('<div class="col-2"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter(campo.parent());
}

var valorAnterior;

campo.on('change', function() {
    if ((campo.val() != 'todos' && campo.val() != 'status') && ($(document).find('#valor').length == 0 || valorAnterior == 'status')) {
        if ($(document).find('#valor').length != 0 ) {
            $(document).find('#valor').parent().remove();
        }
        $('<div class="col-2"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter(campo.parent());
    } else if (campo.val() == 'status' && ($(document).find('#valor').length == 0 || valorAnterior != 'status')) {
        if ($(document).find('#valor').length != 0 ) {
            $(document).find('#valor').parent().remove();
        }
        var div = $('<div>').attr('class', 'col-2');
        var select = $('<select>').attr('class', 'form-select');
        var label = $('<label for="status">Valor</label>');
        select.attr('name', 'valor');
        select.attr('id', 'valor');
        select.attr('required');

        select.append(new Option('Todos', 'Todos'));
        select.append(new Option('Abertos', 'ABERTO'));
        select.append(new Option('Aguardando', 'AGUARDANDO'));
        select.append(new Option('Encerrados', 'ENCERRADO'));

        div.append(label);
        div.append(select);
        div.insertAfter(campo.parent());
    } else if (campo.val() == 'todos') {
        $(document).find('#valor').parent().remove();
    }

    valorAnterior = $(this).val();
});