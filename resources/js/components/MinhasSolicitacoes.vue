<template>
    <div class="card-box">
        <div id="card-header">
            <h1>Minhas Solicitações</h1>
            <div>
                <a class="btn btn-dark" :href="url+'/solicitar'">Solicitar</a>
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
        >
            <template #emptystate>
                <div class="text-center">
                    Nenhuma Solicitação Encontrada.
                </div>
            </template>
            <template #table-row="props">
                <span v-if="props.column.field == 'status' && props.row.status == 'Aberto'">
                    <span class="text-success">{{props.row.status}}</span> 
                </span>
                <span v-else-if="props.column.field == 'status' && props.row.status == 'Liberado'">
                    <span class="text-info">{{props.row.status}}</span> 
                </span>
                <span v-else-if="props.column.field == 'status' && props.row.status == 'Aguardando'">
                    <span class="text-warning">{{props.row.status}}</span> 
                </span>
                <span v-else-if="props.column.field == 'status' && props.row.status == 'Encerrado'">
                    <span class="text-primary">{{props.row.status}}</span> 
                </span>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
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
            url: window.location.origin
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