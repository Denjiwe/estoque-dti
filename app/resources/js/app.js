import './bootstrap';

import '../sass/app.scss';

import {createApp} from 'vue';

const app = createApp({});

import CardComponent from './components/Card.vue';
app.component('Card', CardComponent);

import PaginateComponent from './components/Paginate.vue';
app.component('Paginate', PaginateComponent);

import ModalComponent from './components/Modal.vue';
app.component('Modal', ModalComponent);

app.mount('#app');