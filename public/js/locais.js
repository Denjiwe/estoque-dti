let trLocal = document.querySelector('.linha');
var urlBase = 'http://localhost:80/api/';

$('#adicionar').click(function() {
    var novaLinha = $(trLocal).clone(true);
    novaLinha.find('select[id="divisao"]').val('');
    novaLinha.find('select[id="diretoria"]').val('');
    novaLinha.appendTo('#tbody');

});

async function divisoes(diretoriaId, selectDivisao){
    selectDivisao.prop('disabled', true);
    selectDivisao.empty();
    selectDivisao.append($('<option>').val('').text('Nenhuma'));

    url = urlBase+'dados-por-diretoria/'+diretoriaId;

    await fetch(url,{
        method: 'GET',
        headers: {
            'Accept' : 'application/json'
        }
    })
        .then(response=>response.json())
        .then(data => {
            data[0].forEach(divisao => {
                selectDivisao.append($('<option>').val(divisao.id).text(divisao.nome));
            });

            selectDivisao.prop('disabled', false);
        });
}

$(document).on('change', '.diretoria', async function(){
    var diretoriaId = $(this).val();
    await divisoes(diretoriaId, $(this).parent().parent().find('select[id="divisao"]'));
});

$(document).on('click', '.remover',function() {
    $(this).closest('.linha').remove();

    if ($('.linha').length === 0) {
        var novaLinha = $(trLocal).clone(true);
        novaLinha.find('select[id="divisao"]').val('');
        novaLinha.find('select[id="diretoria"]').val('');
        novaLinha.appendTo('#tbody');
    }
});
