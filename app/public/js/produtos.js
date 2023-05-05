let tipoProduto = document.querySelector('#tipo_produto');
let quantidade = document.querySelector('#qntde_estoque');
let divTipoProduto = document.querySelector('#divTipoProduto');
let tooltip = document.querySelector('#tooltip');

tipoProduto.addEventListener('change', () => {
    if (tipoProduto.value == 'IMPRESSORA') {
        quantidade.value = 0;
        quantidade.disabled = true;
        divTipoProduto.classList.replace('col-12', 'col-9');
        tooltip.style.display = 'flex';
    } else {
        quantidade.value = '';
        quantidade.disabled = false;
        divTipoProduto.classList.replace('col-9', 'col-12');
        tooltip.style.display = 'none';    
    }
});


var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})