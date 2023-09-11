let tipoProduto = document.querySelector('#tipo_produto');
let quantidade = document.querySelector('#qntde_estoque');
let divTipoProduto = document.querySelector('#divTipoProduto');
let tooltip = document.querySelector('#tooltip');
let descricao = document.querySelector('#divDescricao');
let locaisLi = document.querySelector('#locais-li');
let impressorasLi = document.querySelector('#impressoras-li');
let suprimentosLi = document.querySelector('#suprimentos-li');
let primeiroHandle = document.querySelector('#primeiro-handle');
let proximoInput = document.querySelector('#proximoInput');
let form = document.querySelector('#form');

tipoProduto.addEventListener('change', () => {
    switch (tipoProduto.value) {
        case 'IMPRESSORA':
            // inputs
            quantidade.value = 0;
            quantidade.disabled = true;
            divTipoProduto.classList.replace('col-12', 'col-9');
            tooltip.style.display = 'flex';

            // tabs e afins
            locaisLi.style.display = 'flex';
            impressorasLi.style.display = 'none';
            suprimentosLi.style.display = '';
            primeiroHandle.style.display = '';
            btnSubmit.style.display = 'none';
            break;
        case 'TONER':
        case'CILINDRO' :
            // inputs
            quantidade.disabled = false;
            divTipoProduto.classList.replace('col-9', 'col-12');
            tooltip.style.display = 'none';    

            // tabs e afins
            locaisLi.style.display = 'none';
            impressorasLi.style.display = 'flex';
            primeiroHandle.style.display = '';
            suprimentosLi.style.display = 'none';
            btnSubmit.style.display = 'none';
            break;
        case 'OUTROS' :
            // inputs
            quantidade.disabled = false;
            divTipoProduto.classList.replace('col-9', 'col-12');
            tooltip.style.display = 'none';    

            // tabs e afins
            impressorasLi.style.display = 'none';
            locaisLi.style.display = 'none';
            suprimentosLi.style.display = 'none';
            primeiroHandle.style.display = 'none';
            btnSubmit.style.display = '';
            break;
    }
});

switch (tipoProduto.value) {
    case 'IMPRESSORA':
        console.log(quantidade.value);
        if (quantidade.value == '' || quantidade.value == 0 || quantidade.value == null) {
            // inputs
            if (quantidade.value == '') quantidade.value = 0;
            quantidade.disabled = true;
            divTipoProduto.classList.replace('col-12', 'col-9');
            tooltip.style.display = 'flex';

            // tabs e afins
            locaisLi.style.display = 'flex';
            impressorasLi.style.display = 'none';
            suprimentosLi.style.display = '';
            primeiroHandle.style.display = '';
        }
        break;
    case 'TONER':
    case'CILINDRO' :
        // inputs
        quantidade.disabled = false;
        divTipoProduto.classList.replace('col-9', 'col-12');
        tooltip.style.display = 'none';    

        // tabs e afins
        locaisLi.style.display = 'none';
        impressorasLi.style.display = 'flex';
        primeiroHandle.style.display = '';
        suprimentosLi.style.display = 'none';
        break;
    case 'OUTROS' :
        // inputs
        quantidade.disabled = false;
        divTipoProduto.classList.replace('col-9', 'col-12');
        tooltip.style.display = 'none';    

        // tabs e afins
        impressorasLi.style.display = 'none';
        locaisLi.style.display = 'none';
        suprimentosLi.style.display = 'none';
        primeiroHandle.style.display = 'none';
        btnSubmit.style.display = '';
        break;
}

$('.handle_aba').on('click', (obj) => {

    obj.preventDefault();
    
    tipoProduto.disabled = false;

    switch (tipoProduto.value) {
        case 'IMPRESSORA':
            proximoInput.value = 'locais';
            quantidade.disabled = false;
            break;
        case 'TONER':
        case 'CILINDRO':
            proximoInput.value = 'impressoras'
            break;
        case 'OUTROS':
            proximoInput.value = 'nenhum'
            break;
    }

    form.submit();
});

$('#btnSubmit').on('click', (obj) => {

    obj.preventDefault();
    
    tipoProduto.disabled = false;
    quantidade.disabled = false;

    proximoInput.value = 'nenhum'

    form.submit();
});