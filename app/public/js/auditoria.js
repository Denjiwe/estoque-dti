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
