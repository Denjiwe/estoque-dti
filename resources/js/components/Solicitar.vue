<template>
    <div class="card-box">
        <h1>Solicitar</h1>
        <div class="row">
            <div class="col-3">
                <label class="form-label">Impressora</label>
                <select 
                    class="form-select" 
                    aria-label="Impressoras"
                    v-model="impressora"
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
                <label class="form-label">Produtos</label>
                <select class="form-select" aria-label="Produtos" v-model="produto">
                    <option value="" selected hidden>-- Selecione um tipo de produto --</option>
                    <option value="toner">Toner</option>
                    <option value="cilindro">Cilindro</option>
                    <option value="conjunto">Conjunto</option>
                </select>
            </div>

            <div class="col-3">
                <label class="form-label">Quantidade</label>
                <input 
                    type="number" 
                    class="form-control" 
                    aria-label="Quantidade" 
                    placeholder="Informe a quantidade" 
                    min="1" 
                    max="2" 
                    v-model="quantidade"
                >
            </div>

            <div class="col-3 mt-n3">
                <button type="button" class="btn btn-dark mt-5" @click="addSuprimento()">Adicionar</button>
            </div>

            <div id="card-produtos" v-if="produtosCart.length > 0">
                <div v-for="produto in produtosCart" :key="produto.id">
                    <span>{{ produto.nome }}</span>
                    <button type="button" class="quantidade mx-2" @click="diminuiQuantidade(produto.id)">-</button>
                    <span>{{ produto.quantidade }}</span>
                    <button type="button" class="quantidade mx-2" @click="addQuantidade(produto.id)" :disabled="produto.quantidade >= 2">+</button>
                    <button type="button" class="remover mx-2" @click="remove(produto.id)">Remover</button>
                </div>
            </div>

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
        async addSuprimento() {
            if (this.impressora == '' || this.produto == '' || this.quantidade == null) return alert('Preencha todos os campos');

            const cases = {toner: this.buscaToner, cilindro: this.buscaCilindro, conjunto: this.buscaConjunto};
            await cases[this.produto](this.impressora);

            this.impressora = '';
            this.produto = '';
            this.quantidade = null;
        },
        async buscaToner(id) {
            await axios.get(urlBase + 'toner-por-impressora/' + id).then((response) => {
                if (this.verificaDuplicado(response.data.id)) return;
                this.produtosCart.push({id: response.data.id, nome: response.data.modelo_produto, quantidade: this.quantidade});
            });
        },
        async buscaCilindro(id) {
            await axios.get(urlBase + 'cilindro-por-impressora/' + id).then((response) => {
                if (this.verificaDuplicado(response.data.id)) return;
                this.produtosCart.push({id: response.data.id, nome: response.data.modelo_produto, quantidade: this.quantidade});
            })
        },
        async buscaConjunto(id) {
            await axios.get(urlBase + 'conjunto-por-impressora/' + id).then((response) => {
                for (let i = 0; i < response.data.length; i++) {
                    if (!this.verificaDuplicado(response.data[i].original.id))
                    this.produtosCart.push({id: response.data[i].original.id, nome: response.data[i].original.modelo_produto, quantidade: this.quantidade});
                }
            })
        },
        verificaDuplicado(id) {
            var duplicado = false;
            this.produtosCart.map((prod, index) => {
                if (this.produtosCart[index].id == id) {
                    this.produtosCart[index].quantidade += this.quantidade; 
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
        margin-top: 1rem;
        background-color: #bcbdc0;
        border-radius: .5rem;
        border: 1px solid #747474;
        padding: 1rem;
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
        border: 1px solid #747474;
        color: white;
    }
</style>