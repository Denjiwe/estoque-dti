import { urlBase } from './urlBase.js';
let trLocal = document.querySelector('.linha');
let form = document.querySelector('#form');

$('#adicionar').click(function() {
    var novaLinha = $(trLocal).clone(true);
    novaLinha.find('select[id="divisao"]').val('').removeClass('custom-select').addClass('form-control').removeAttr('disabled');
    novaLinha.find('select[id="diretoria"]').val('').removeClass('custom-select').addClass('form-control').removeAttr('disabled').attr('required');
    novaLinha.appendTo('#tbody');

});

async function divisoes(diretoriaId, selectDivisao){
    selectDivisao.prop('disabled', true);
    selectDivisao.empty();
    selectDivisao.append($('<option>').val('').text('Nenhuma'));

    var url = urlBase+'dados-por-diretoria/'+diretoriaId;

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

$('.handle_aba').on('click', (obj) => {

    obj.preventDefault();

    $(document).find('.divisao').each(function() {$(this).removeAttr('disabled')});
    $(document).find('.diretoria').each(function() {$(this).removeAttr('disabled')});

    form.submit();
});
