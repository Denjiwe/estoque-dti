let tipoProduto = document.querySelector('#tipo_produto');
let quantidade = document.querySelector('#qntde_estoque');
let divTipoProduto = document.querySelector('#divTipoProduto');
let tooltip = document.querySelector('#tooltip');
let descricao = document.querySelector('#divDescricao');
let toner = document.querySelector('#divToner');
let cilindro = document.querySelector('#divCilindro');

tipoProduto.addEventListener('change', () => {
    if (tipoProduto.value == 'IMPRESSORA') {
        quantidade.value = 0;
        quantidade.disabled = true;
        divTipoProduto.classList.replace('col-12', 'col-9');
        tooltip.style.display = 'flex';
        descricao.classList.replace('col-6', 'col-5');
        toner.style.display = 'flex';
        cilindro.style.display = 'flex';
    } else {
        quantidade.value = '';
        quantidade.disabled = false;
        divTipoProduto.classList.replace('col-9', 'col-12');
        tooltip.style.display = 'none';    
        descricao.classList.replace('col-5', 'col-6');
        toner.style.display = 'none';
        cilindro.style.display = 'none';
    }
});

$('.prox_aba').on('click', (obj) => {
    var index = $(".active").attr("data_id");//get current active tab
    if (obj == "Previous") {
    index = parseInt(index) - 1;//parseInt() convert index from string type to int type
    }
    else {
    index = parseInt(index) + 1;
    }
    $('.nav-tabs button[data_id="' + index + '"]').tab('show');
})

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})