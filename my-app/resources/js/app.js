import './bootstrap';
import { createApp } from 'vue';
import App from '../js/components/App.vue'
import router from './router/index.js'

createApp(App).use(router).mount('#app')
