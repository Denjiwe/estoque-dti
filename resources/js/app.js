import './bootstrap';

import '../sass/app.scss';

import { createApp } from 'vue';
import MinhasSolicitacoes from './components/MinhasSolicitacoes.vue';
import Solicitar from './components/Solicitar.vue';

const app = createApp({
    components: {
        MinhasSolicitacoes,
        Solicitar,
    },
});

app.mount('#app');
