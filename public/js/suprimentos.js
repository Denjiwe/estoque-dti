$(document).ready(function() {
    let trLocal = document.querySelector('.linha');
    let url = 'http://localhost:80/api/';

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
        var elThis = this;
        if ($(this).closest('#tipo').val() == 'TONER') {
            var urlP = url+'toners'
        } else {
            var urlP = url+'cilindros'
        }

        var selectSuprimento = $(elThis).closest('td').next('td').find('#suprimento');
        $(elThis).closest('td').next('td').addClass('row');

        // Limpar todas as opções existentes
        selectSuprimento.empty();
        selectSuprimento.addClass('col');

        // Adicionar a opção padrão
        $(selectSuprimento).append($('<option>').val('').text('Selecione o suprimento'));

        // Desabilitar o select
        selectSuprimento.prop('disabled', true);

        // Exibir o loader
        var loader = $('<div>').addClass('col-auto ms-2 me-2 mt-2').append($('<div>').addClass('spinner-border spinner-border-sm'));
        selectSuprimento.after(loader);

        fetch(urlP,{
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                // Remover o loader
                loader.remove();

                $(elThis).closest('td').next('td').removeClass('row');

                selectSuprimento.removeClass('col');

                // Habilitar o select
                selectSuprimento.prop('disabled', false);

                data.forEach((produto) => {
                    $(selectSuprimento).append($('<option>').val(produto.id).text(produto.modelo_produto));
                });
            })
    });
});