import './bootstrap';

import '../sass/app.scss';

import {createApp} from 'vue';

const app = createApp({});

import CardComponent from './components/Card.vue';
app.component('card-component', CardComponent);

app.mount('#app');