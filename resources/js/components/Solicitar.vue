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
        }
    },
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
</style>