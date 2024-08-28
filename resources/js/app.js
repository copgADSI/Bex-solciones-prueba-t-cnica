import './bootstrap.js';
import './config/axios.js';
import { VueQueryPlugin } from "vue-query";
import components from './components.ts';
import { createApp } from 'vue';
import store from './store/index.js';

const app = createApp({
    components
});

app.use(VueQueryPlugin);
app.use(store)
app.mount('#app');
