let tipoProduto = document.querySelector('#tipo_produto');
let quantidade = document.querySelector('#qntde_estoque');

tipoProduto.addEventListener('change', () => {
    if (tipoProduto.value == 'IMPRESSORA') {
        quantidade.value = 0;
        quantidade.disabled = true;    
    } else {
        quantidade.value = '';
        quantidade.disabled = false;    
    }
});