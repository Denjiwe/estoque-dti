import { urlBase } from './urlBase.js';

$("#item").on('change', function() {
    $('#tipo').empty();
    $("#tipo").append($('<option value="" selected hidden>-- Selecione --</option>'));
    $('#tipo').attr('disabled', false);
    $('#tipo').removeClass('border-dark');

    if ($(this).val() == 'solicitacoes') {
        $("#tipo").append(new Option('Órgão', 'Orgao'));
        $("#tipo").append(new Option('Diretoria', 'Diretoria'));
        $("#tipo").append(new Option('Divisão', 'Divisao'));
        $("#tipo").append(new Option('Usuário', 'Usuario'));
        $("#tipo").append(new Option('Produto', 'Produto'));
    } 

    if($(this).val() == 'entregas') {
        $("#tipo").append(new Option('Órgão', 'Orgao'));
        $("#tipo").append(new Option('Diretoria', 'Diretoria'));
        $("#tipo").append(new Option('Divisão', 'Divisao'));
        $("#tipo").append(new Option('Usuário', 'Usuario'));
        $("#tipo").append(new Option('Solicitacão', 'Solicitacao'));
    } 

    if($(this).val() == 'usuarios' || $(this).val() == 'impressoras') {
        $("#tipo").append(new Option('Órgão', 'Orgao'));
        $("#tipo").append(new Option('Diretoria', 'Diretoria'));
        $("#tipo").append(new Option('Divisão', 'Divisao'));
    } 
});

$(document).on('change', '#tipo', function() {
    $('#campo').attr('disabled', false);
    $('#campo').removeClass('border-dark');
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
    $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-md-0"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter($('#campo').parent());
    $('#dataDiv').removeClass('mt-md-0').addClass('mt-xl-0');
} 

if ($('#item').val() == 'solicitacoes') {
    $('#tipo').empty();
    $('#tipo').attr('disabled', false);
    $('#tipo').removeClass('border-dark');
    $("#tipo").append($('<option value="" selected hidden>-- Selecione --</option>'));
    $("#tipo").append(new Option('Órgão', 'Orgao'));
    $("#tipo").append(new Option('Diretoria', 'Diretoria'));
    $("#tipo").append(new Option('Divisão', 'Divisao'));
    $("#tipo").append(new Option('Usuário', 'Usuario'));
    $("#tipo").append(new Option('Produto', 'Produto'));
} else if($('#item').val() == 'entregas') {
    $('#tipo').empty();
    $('#tipo').attr('disabled', false);
    $('#tipo').removeClass('border-dark');
    $("#tipo").append($('<option value="" selected hidden>-- Selecione --</option>'));
    $("#tipo").append(new Option('Órgão', 'Orgao'));
    $("#tipo").append(new Option('Diretoria', 'Diretoria'));
    $("#tipo").append(new Option('Divisão', 'Divisao'));
    $("#tipo").append(new Option('Usuário', 'Usuario'));
    $("#tipo").append(new Option('Solicitacão', 'Solicitacao'));
} else if($('#item').val() == 'usuarios' || $('#item').val() == 'impressoras') {
    $('#tipo').empty();
    $('#tipo').attr('disabled', false);
    $('#tipo').removeClass('border-dark');
    $("#tipo").append($('<option value="" selected hidden>-- Selecione --</option>'));
    $("#tipo").append(new Option('Órgão', 'Orgao'));
    $("#tipo").append(new Option('Diretoria', 'Diretoria'));
    $("#tipo").append(new Option('Divisão', 'Divisao'));
} 

var valorAnteriorCampo;

$(document).on('change', '#campo', function() {
    if (($('#campo').val() != 'todos' && $('#campo').val() != 'status') && ($(document).find('#valor').length == 0 || valorAnteriorCampo == 'status') && ($('#tipo')).val() != '') {
        if ($(document).find('#valor').length != 0 ) {
            $(document).find('#valor').parent().remove();
            $('#dataDiv').removeClass('mt-md-0').addClass('mt-xl-0');
        }
        $('#dataDiv').removeClass('mt-md-0').addClass('mt-xl-0');
        $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-md-0"><label>Valor</label><input name="valor" id="valor" type="text" placeholder="Insira o valor do campo" class="form-control" required></div>').insertAfter($('#campo').parent());
    } else if ($('#campo').val() == 'status' && ($(document).find('#valor').length == 0 || valorAnteriorCampo != 'status') && ($('#tipo')).val() != '') {
        if ($(document).find('#valor').length != 0 ) {
            $(document).find('#valor').parent().remove();
            $('#dataDiv').removeClass('mt-xl-0').addClass('mt-md-0');
        }
        var div = $('<div>').addClass('col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-md-0');
        var select = $('<select>').addClass('form-control');
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
        $('#dataDiv').removeClass('mt-md-0').addClass('mt-xl-0');
    } else if ($(document).find('#campo').val() == 'todos') {
        $(document).find('#valor').parent().remove();
        $('#dataDiv').removeClass('mt-xl-0').addClass('mt-md-0');
    }

    valorAnteriorCampo = $(this).val();
});

$(document).on('keyup', '#valor', function() {
    var valor = $(this).val();

    if (valor.length > 2 && $(document).find('#campo').val() == 'nome') {
        fetch(
            urlBase + 'busca/' + $('#tipo').val() + '/' + valor,
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
    var dataInicio = $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Data de Inicio</label><input id="data_inicio" name="data_inicio" type="date" class="form-control" required></div>');
    var dataFinal = $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Data de Fim</label><input id="data_final" name="data_final" type="date" class="form-control" required></div>');
    var dataDiv = $('#dataDiv');
    dataFinal.insertAfter(dataDiv);
    dataInicio.insertAfter(dataDiv);
}

data.on('change', function() {
    if(data.val() == 'personalizado') {
        var dataInicio = $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Data de Inicio</label><input id="data_inicio" name="data_inicio" type="date" class="form-control" required></div>');
        var dataFinal = $('<div class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Data de Fim</label><input id="data_final" name="data_final" type="date" class="form-control" required></div>');
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

$('#formato').on('change', function() {
    if($(this).val() == 'pdf') {
        var orientacao = $('<div id="orientacaoDiv" class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Orientação</label><select id="orientacao" name="orientacao" class="form-control"><option value="portrait" selected>Retrato</option><option value="landscape">Paisagem</option></select></div>');
        orientacao.insertAfter($('#formato').parent());
    } else {
        $('#orientacaoDiv').remove();
    }
});

if($('#formato').val() == 'pdf') {
    var orientacao = $('<div id="orientacaoDiv"  class="col-12 col-sm-4 col-md-3 col-xl-2 mt-3 mt-xl-0"><label>Orientação</label><select id="orientacao" name="orientacao" class="form-control"><option value="portrait" selected>Retrato</option><option value="landscape">Paisagem</option></select></div>');
    orientacao.insertAfter($('#formato').parent());
}