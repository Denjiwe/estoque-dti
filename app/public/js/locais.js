let trLocal = document.querySelector('.linha');

$('#adicionar').click(function() {
    var novaLinha = $(trLocal).clone(true);
    novaLinha.find('select[id="divisao"]').val('');
    novaLinha.find('select[id="diretoria"]').val('');
    novaLinha.appendTo('#tbody');

});

$(document).on('click', '.remover',function(e) {
    $(this).closest('.linha').remove();

    if ($('.linha').length === 0) {
        var novaLinha = $(trLocal).clone(true);
        novaLinha.find('select[id="divisao"]').val('');
        novaLinha.find('select[id="diretoria"]').val('');
        novaLinha.appendTo('#tbody'); 
    }
});