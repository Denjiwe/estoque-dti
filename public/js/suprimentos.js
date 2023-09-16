import { urlBase } from './urlBase.js';

$(document).ready(function() {
    let trLocal = document.querySelector('.linha');

    $('#adicionar').click(function() {
        var novaLinha = $(trLocal).clone(true);
        novaLinha.find('select[id="tipo"]').val('');
        novaLinha.find('select[id="suprimento"]').val('');
        novaLinha.find('select[id="em_uso"]').val('NAO');

        // Limpar todas as opções existentes
        novaLinha.find('select[id="suprimento"]').empty();

        // Adicionar a opção padrão
        novaLinha.find('select[id="suprimento"]').append($('<option>').val('').text('Selecione o suprimento'));
        novaLinha.appendTo('#tbody');

    });

    $(document).on('click', '.remover',function(e) {
        $(this).closest('.linha').remove();

        if ($('.linha').length === 0) {
            var novaLinha = $(trLocal).clone(true);
            novaLinha.find('select[id="tipo"]').val('');
            novaLinha.find('select[id="suprimento"]').val('');
            novaLinha.find('select[id="em_uso"]').val('NAO');

            // Limpar todas as opções existentes
            novaLinha.find('select[id="suprimento"]').empty();

            // Adicionar a opção padrão
            novaLinha.find('select[id="suprimento"]').append($('<option>').val('').text('Selecione o suprimento'));
            novaLinha.appendTo('#tbody');
        }
    });

    $(document).on('change', '#tipo',function(e) {
        if ($(this).closest('#tipo').val() == 'TONER') {
            var urlP = urlBase+'toners'
        } else {
            var urlP = urlBase+'cilindros'
        }

        var selectSuprimento = $(this).closest('td').next('td').find('#suprimento');

        // Limpar todas as opções existentes
        selectSuprimento.empty();

        // Adicionar a opção padrão
        $(selectSuprimento).append($('<option>').val('').text('Selecione o suprimento'));

        // Desabilitar o select
        selectSuprimento.prop('disabled', true);

        fetch(urlP,{
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Habilitar o select
                selectSuprimento.prop('disabled', false);

                data.forEach((produto) => {
                    $(selectSuprimento).append($('<option>').val(produto.id).text(produto.modelo_produto));
                });
            })
    });
});
