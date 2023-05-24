$(document).ready(function() {
    let trLocal = document.querySelector('.linha');
    let url = 'http://localhost:8000/api/';


    // Função para carregar os produtos correspondentes ao tipo selecionado
    function carregarProdutos(tipo) {
      // Realize uma requisição AJAX ou use uma lista de produtos predefinida
      // Aqui, vamos simular uma requisição AJAX com uma lista de produtos para cada tipo

        var produtos = [];  
        // Verifica o tipo selecionado e carrega os produtos correspondentes
        if (tipo === 'toner') {
            produtos = produtosToner;
        } else if (tipo === 'cilindro') {
            produtos = produtosCilindro;
        }

      // Limpa o select de produtos
        $('#produtos').empty();

      // Adiciona as opções dos produtos correspondentes ao select
        produtos.forEach(function(produto) {
            var option = $('<option>').val(produto.id).text(produto.nome);
            $('#produtos').append(option);
        });
    }
    
    // Evento de alteração do primeiro select
    $('#tipo_produto').on('change', function() {
        var tipoSelecionado = $(this).val();
        carregarProdutos(tipoSelecionado);
    });

    // Inicialmente, carrega os produtos com base no valor inicial do primeiro select
    var tipoInicial = $('#tipo_produto').val();
    carregarProdutos(tipoInicial);

    $('#adicionar').click(function() {
        var novaLinha = $(trLocal).clone(true);
        novaLinha.find('select[id="tipo"]').val('');
        novaLinha.find('select[id="suprimento"]').val('');
        novaLinha.appendTo('#tbody');
    
    });
    
    $(document).on('click', '.remover',function(e) {
        $(this).closest('.linha').remove();
    
        if ($('.linha').length === 0) {
            var novaLinha = $(trLocal).clone(true);
            novaLinha.find('select[id="tipo"]').val('');
            novaLinha.find('select[id="suprimento"]').val('');
            novaLinha.appendTo('#tbody'); 
        }
    });
    
    $(document).on('change', '#tipo',function(e) {
        if ($(this).closest('#tipo').val() == 'TONER') {
            var urlP = url+'toners'
        } else {
            var urlP = url+'cilindros'
        }

        fetch(urlP,{
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(Response => {
                produtos = Response;
                console.log(produtos);
            })
    });
});

