import './bootstrap';

import '../sass/app.scss';

import {createApp} from 'vue';

const app = createApp({});

import BoxComponent from './components/Box.vue';
app.component('Box', BoxComponent);

import PaginateComponent from './components/Paginate.vue';
app.component('Paginate', PaginateComponent);

import ModalComponent from './components/Modal.vue';
app.component('Modal', ModalComponent);

app.mount('#app');