<template>
    <div class="card-box">
        <div id="card-header">
            <h1>Minhas Solicitações</h1>
            <div>
                <a class="btn btn-dark" :href="url+'solicitar'">Solicitar</a>
            </div>
        </div>
        <vue-good-table
            :columns="columns"
            :rows="rows"
            compactMode
            :search-options="{
            enabled: true,
            placeholder: 'Pesquisar',
            }"
            :pagination-options="{
                enabled: true,
                rowsPerPageLabel: 'Registros por página',
                nextLabel: 'Próxima',
                prevLabel: 'Anterior',
                infoFn: (params) => `Mostrando de ${params.firstRecordOnPage} até ${params.lastRecordOnPage} da página ${params.currentPage}`,
                allLabel: 'Todos',
            }">
        ></vue-good-table>
    </div>
</template>

<script>
import { urlBase } from '../../../public/js/urlBase.js';
import 'vue-good-table-next/dist/vue-good-table-next.css'
import { VueGoodTable } from 'vue-good-table-next';

export default {
    components: {
        VueGoodTable
    },
    props: {
        solicitacoes: Array
    },
    setup(props) {
        const url = urlBase.slice(0, -4);
        return {
            VueGoodTable,
            columns: [
                {
                    label: 'Código',
                    field: 'id',
                },
                {
                    label: 'Produtos',
                    field: 'produtos',
                },
                {
                    label: 'Status',
                    field: 'status',
                },
                {
                    label: 'Criação',
                    field: 'created_at',
                } 
            ],
            rows: props.solicitacoes,
            url
        };
    }
};
</script>

<style scoped>
    #card-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
</style>