import './bootstrap';

import '../sass/app.scss';

import { createApp } from 'vue';
import MinhasSolicitacoes from './components/MinhasSolicitacoes.vue';
import Solicitar from './components/Solicitar.vue';
import Layout from './components/Layout.vue';
import VueGoodTablePlugin from 'vue-good-table-next';

const app = createApp();

app.component('minhas-solicitacoes', MinhasSolicitacoes);
app.component('solicitar', Solicitar);
app.component('layout', Layout);
app.use(VueGoodTablePlugin);

app.mount('#app');