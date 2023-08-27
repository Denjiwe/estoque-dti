var url = 'http://localhost:80/api/';
var valorAnteriorItem;

$("#item").on('change', function() {
    if ($(this).val() == 'solicitacoes') {
        $("#tipo").find('option[value="Solicitacao"]').remove();
    } else if ($(this).val() != 'solicitacoes' && valorAnteriorItem == 'solicitacoes') {
        $("#tipo").append(new Option('Solicitacão', 'Solicitacao'));
    }

    if($(this).val() == 'entregas') {
        $("#tipo").find('option[value="Entrega"]').remove();
    } else if ($(this).val() != 'entregas' && valorAnteriorItem == 'entregas') {
        $("#tipo").append(new Option('Entrega', 'Entrega'));
    }

    if($(this).val() == 'usuarios') {
        $("#tipo").find('option[value="Usuario"]').remove();
    } else if ($(this).val() != 'usuarios' && valorAnteriorItem == 'usuarios') {
        $("#tipo").append(new Option('Usuário', 'Usuario'));
    }

    valorAnteriorItem = $(this).val();
});

$(document).on('change', '#tipo', function() {
    $('#campo').attr('disabled', false);
    if ($(this).val() == 'Solicitacao') {
        $('#campo').append(new Option('Status', 'status'));
        if($('#campo').find('option[value="nome"]').length) {
            $('#campo').find('option[value="nome"]').remove();
        }
    } else if($(this).val() == 'Entrega') {
        if($('#campo').find('option[value="nome"]').length) {
            $('#campo').find('option[value="nome"]').remove();
        }
        if($('#campo').find('option[value="status"]').length) {
            $('#campo').find('option[value="status"]').remove();
        }
    } else {
        if($('#campo').find('option[value="status"]').length) {
            $('#campo').find('option[value="status"]').remove();
        }
        if(!$('#campo').find('option[value="nome"]').length) {
            $('#campo').append(new Option('Nome', 'nome'));
        }
    }
});

if($('#campo').val() != 'todos') {
    $('<div class="col-2"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter($('#campo').parent());
}

var valorAnteriorCampo;

$(document).on('change', '#campo', function() {
    if (($('#campo').val() != 'todos' && $('#campo').val() != 'status') && ($(document).find('#valor').length == 0 || valorAnteriorCampo == 'status') && ($('#tipo')).val() != '') {
        if ($(document).find('#valor').length != 0 ) {
            $(document).find('#valor').parent().remove();
        }
        $('<div class="col-2"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter($('#campo').parent());
    } else if ($('#campo').val() == 'status' && ($(document).find('#valor').length == 0 || valorAnteriorCampo != 'status') && ($('#tipo')).val() != '') {
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
        div.insertAfter($('#campo').parent());
    } else if ($(document).find('#campo').val() == 'todos') {
        $(document).find('#valor').parent().remove();
    }

    valorAnteriorCampo = $(this).val();
});

$(document).on('keyup', '#valor', function() {
    var valor = $(this).val();

    if (valor.length > 2 && $(document).find('#campo').val() == 'nome') {
        fetch(
            url + 'busca/' + $('#tipo').val() + '/' + valor,
            {method: 'GET', headers: {'Accept': 'application/json'}}
        ).then(response => response.json()).then(data => {
            $('#nome').remove();
            if($(document).find('#valor').val().length > 2) {
                $('#valor').parent().append('<div id="nome">');
                data.forEach((item) => {
                    if($(document).find('#valor').val() == item.nome) {
                        $('#nome').remove();
                    } else {
                        $('#nome').append('<div class="nome-item">' + item.nome + '</div>');  
                    }
                })
            }
        })
    } else {
        $('#nome').remove();
    }
});

$(document).on('click', '.nome-item', function() {
    $('#valor').val($(this).text());
    $('#nome').remove();
});

var data = $('#data');
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