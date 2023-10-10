<template>
    <div class="card-box">
        <h1>Solicitar</h1>
        <div class="row">
            <div class="col-3">
                <div style="display: flex; flex-direction: row;">
                    <label class="form-label">Impressora</label>
                    <div class="tooltips">
                        <p class="fa fa-question-circle"></p>
                        <span class="tooltiptext">Selecione o modelo da impressora. O modelo geralmente está escrito na parte frontal da impressora, Ex: HP 1102W.</span>
                    </div>
                </div>
                <select 
                    class="form-select" 
                    aria-label="Impressoras"
                    v-model="impressora"
                    id="impressoras"
                    @focus="limpaCampo($event.target)"
                >
                    <option value="" selected hidden>-- Selecione uma Impressora --</option>
                    <option 
                        v-for="impressora in impressoras" 
                        :key="impressora.id" 
                        :value="impressora.id"
                    >{{ impressora.modelo_produto }}</option>
                </select>
            </div>

            <div class="col-3">
                <div style="display: flex; flex-direction: row;">
                    <label class="form-label">Produtos</label>
                    <div class="tooltips">
                        <p class="fa fa-question-circle"></p>
                        <span class="tooltiptext">Selecione o tipo de produto a ser trocado.</span>
                    </div>
                </div>
                <select class="form-select" aria-label="Produtos" v-model="produto" id="produtosInput" @focus="limpaCampo($event.target)">
                    <option value="" selected hidden>-- Selecione um tipo de produto --</option>
                    <option value="toner">Toner</option>
                    <option value="cilindro">Cilindro</option>
                    <option value="conjunto">Conjunto</option>
                </select>
            </div>

            <div class="col-3">
                <div style="display: flex; flex-direction: row;">
                    <label class="form-label">Quantidade</label>
                    <div class="tooltips">
                        <p class="fa fa-question-circle"></p>
                        <span class="tooltiptext">Informe a quantidade de produtos a serem trocados.</span>
                    </div>
                </div>
                <input 
                    type="number" 
                    class="form-control" 
                    aria-label="Quantidade" 
                    placeholder="Informe a quantidade"
                    v-model="quantidade"
                    id="quantidade"
                    @input="verificaQuantidade"
                    @focus="limpaCampo($event.target)"
                >
            </div>

            <div class="col-3 mt-n3">
                <button type="button" class="btn btn-dark mt-5" @click="addSuprimento()">Adicionar</button>
            </div>

            <h4 class="mt-3">Produtos:</h4>
            <div id="card-produtos" v-if="produtosCart.length > 0">
                <div id="produtos">
                    <div v-for="produto in produtosCart" :key="produto.id" class="produto">
                        <span>{{ produto.nome }}</span>
                        <button type="button" class="quantidade mx-2" @click="diminuiQuantidade(produto.id)">-</button>
                        <span>{{ produto.quantidade }}</span>
                        <button type="button" class="quantidade mx-2" @click="addQuantidade(produto.id)" :disabled="produto.quantidade >= 2">+</button>
                        <button type="button" class="remover mx-2" @click="remove(produto.id)">Remover</button>
                    </div>
                </div>
            </div>
            <p v-else>Nenhum produto adicionado.</p>

            <div class="col-12 mt-4">
                <button type="button" class="btn btn-dark float-end" @click="enviar()" v-if="produtosCart.length > 0">Solicitar</button>
                <a :href="url+'/minhas-solicitacoes'" class="btn btn-secondary float-end me-2">Voltar</a>
            </div>
        </div>
    </div>

    <div class="modal fade show" tabindex="-1" style="display: block;" aria-modal="true" role="dialog" v-if="showModal === true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Solicitação #{{ solicitacaoId }} criada!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar" @click="fecharModal"></button>
                </div>
                <div class="modal-body">
                    <h5>Status do Pedido: <span :class="status === 'ABERTO' ? 'text-success' : 'text-warning'">{{ status }}</span></h5>
                    <div v-if="produtosEmEstoque.length > 0">
                        <h5 class="text-success">Produtos em Estoque:</h5>
                        <ul>
                            <li v-for="produto in produtosEmEstoque" :key="produto">{{ produto }}</li>
                        </ul>
                    </div>

                    <div v-if="produtosEmFalta.length > 0">
                        <h5 class="text-danger">Produtos em Falta:</h5>
                        <ul>
                            <li v-for="produto in produtosEmFalta" :key="produto">{{ produto }}</li>
                        </ul>
                    </div>

                    <p v-if="status === 'AGUARDANDO'">Um ou mais pedidos estão fora de estoque, pedimos que aguarde até que eles estejam disponíveis. Assim que estiverem, a solicitação será alterada para o status de <span class="text-info">Liberado</span> e um email de aviso será enviado.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="fecharModal">Fechar</button>
                    <a :href="url+'/minhas-solicitacoes'" class="btn btn-primary">Minhas Solicitações</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { urlBase } from "../../../public/js/urlBase.js";
import axios from "axios";

export default {
    data() {
        return {
            impressora: '',
            produto: '',
            quantidade: null,
            produtosCart: [],
            showModal: false,
            produtosEmEstoque: [],
            produtosEmFalta: [],
            solicitacaoId: null,
            status: ''
        }
    },
    props: {
        usuarioId: {type: Number, required: true},
        impressoras: {type: Array, required: true}
    },
    methods: {
        verificaQuantidade() {
            if (this.quantidade !== 1 && this.quantidade !== 2) {
                this.quantidade = null;
            }
        },
        async addSuprimento() {
            if (this.impressora == '' || this.produto == '' || this.quantidade == null) {
                if (this.impressora == '') {
                    this.invalidaCampo('#impressoras', 'Selecione uma impressora.');
                }
                if (this.produto == '') {
                    this.invalidaCampo('#produtosInput', 'Selecione um tipo de produto.');
                }
                if (this.quantidade == null) {
                    this.invalidaCampo('#quantidade', 'Selecione uma quantidade.');
                }
                return;
            }

            const cases = {toner: this.buscaToner, cilindro: this.buscaCilindro, conjunto: this.buscaConjunto};
            await cases[this.produto](this.impressora);

            this.impressora = '';
            this.produto = '';
            this.quantidade = null;
        },
        invalidaCampo(id, texto) {
            var input = document.querySelector(id);
            var div = input.parentNode;
            if(!input.classList.contains('is-invalid')) {
                input.classList.add('is-invalid');
                var span = document.createElement('span');
                span.style.color = 'red';
                span.classList.add("erro");
                span.textContent = texto;
                div.appendChild(span);
            }
        },
        limpaCampo(elemento) {
            if (elemento.classList.contains('is-invalid')) {
                elemento.classList.remove('is-invalid');
                elemento.parentNode.querySelector('.erro').remove();
            }
        },
        async buscaToner(id) {
            await axios.get(urlBase + 'toner-por-impressora/' + id).then((response) => {
                if (this.verificaQuantidade(response.data.id)) return;
                if (response.data == []) {
                    this.invalidaCampo('#produtosInput', 'A impressora não possui toner cadastrado');
                    return;
                }
                this.produtosCart.push({id: response.data.id, nome: response.data.modelo_produto, quantidade: this.quantidade});
            });
        },
        async buscaCilindro(id) {
            await axios.get(urlBase + 'cilindro-por-impressora/' + id).then((response) => {
                if (this.verificaQuantidade(response.data.id)) return;
                if (response.data == []) {
                    this.invalidaCampo('#produtosInput', 'A impressora não possui cilindro cadastrado');
                    return;
                }
                this.produtosCart.push({id: response.data.id, nome: response.data.modelo_produto, quantidade: this.quantidade});
            })
        },
        async buscaConjunto(id) {
            await axios.get(urlBase + 'conjunto-por-impressora/' + id).then((response) => {
                for (let i = 0; i < response.data.length; i++) {
                    if (!this.verificaQuantidade(response.data[i].original.id))
                    if (response.data[0] == {}) {
                        this.invalidaCampo('#produtosInput', 'A impressora não possui toner cadastrado');
                        return;
                    }
                    if (response.data[1] == {}) {
                        this.invalidaCampo('#produtosInput', 'A impressora não possui cilindro cadastrado');
                        return;
                    }
                    this.produtosCart.push({id: response.data[i].original.id, nome: response.data[i].original.modelo_produto, quantidade: this.quantidade});
                }
            })
        },
        verificaQuantidade(id) {
            var duplicado = false;
            this.produtosCart.map((prod, index) => {
                if (this.produtosCart[index].id == id) {
                    this.produtosCart[index].quantidade += this.quantidade; 
                    if (this.produtosCart[index].quantidade > 2) {
                        this.produtosCart[index].quantidade = 2;
                    }
                    return duplicado = true;
                }
            });
            return duplicado;
        },
        addQuantidade(id) {
            this.produtosCart.map((prod, index) => {
                if(this.produtosCart[index].id == id) {
                    this.produtosCart[index].quantidade += 1;
                    return;
                }
            })
        },
        diminuiQuantidade(id) {
            this.produtosCart.map((prod, index) => {
                if(this.produtosCart[index].id == id) {
                    this.produtosCart[index].quantidade -= 1;
                    if (this.produtosCart[index].quantidade == 0) {
                        this.produtosCart.splice(index, 1);
                    }
                    return;
                }
            });
        },
        remove(id) {
            this.produtosCart.map((prod, index) => {
                if(this.produtosCart[index].id == id) {
                    this.produtosCart.splice(index, 1);
                }
            })
        },
        async enviar() {
            await axios.post(urlBase + 'solicitar', {
                produtos: this.produtosCart,
                usuario_id: this.usuarioId
            }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            }).then((response) => {
                this.solicitacaoId = response.data.id;
                this.status = response.data.status;
                this.produtosEmEstoque = response.data.produtosEmEstoque;
                this.produtosEmFalta = response.data.produtosEmFalta;
                this.produtosCart = [];
                this.impressora = '';
                this.produto = '';
                this.quantidade = null;
                this.showModal = true;
            })
        },
        fecharModal() {
            this.showModal = false;
            this.produtosEmEstoque = [];
            this.produtosEmFalta = [];
            this.status = '';
            this.solicitacaoId = null;
        }
    },
    setup() {
        return {
            url: window.location.origin
        }
    }
};
</script>

<style scoped>
    #card-produtos {
        background-color: #bcbdc0;
        border-radius: .5rem;
        border: 1px solid #747474;
        padding: .5rem;
        width: max-content;
        color: #000;
        font-size: large;
        margin-left: 1rem;
    }
    #produtos {
        border-radius: .5rem;
        border: 2px solid #000;
        background-color: #ffffff;
    }
    .tooltips {
        position: relative;
        display: inline-block;
        margin-left: 10px;
        margin-top: -1.5px;
    }
    .tooltips .tooltiptext {
        visibility: hidden;
        width: 230px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 5px;
        border-radius: 6px;
        font-size: 12px;
        position: absolute;
        bottom: 100%;
        left: 50%;
        margin-left: -60px;
    }

    .tooltips:hover .tooltiptext {
        visibility: visible;
    }
    .produto {
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
        padding: 10px;
    }
    .quantidade {
        padding-inline: 7px;
        padding-block: 0;
        background-color: #ebebeb;
        border-radius: .25rem;
        border: 1px solid #747474;
    }
    .quantidade:disabled{
        background-color: #f1f1f1;
        border: none;
    }
    .remover {
        padding-inline: 7px;
        padding-block: 0;
        background-color: #e40000;
        border-radius: .25rem;
        border: 1px solid #000;
        color: white;
    }
</style>