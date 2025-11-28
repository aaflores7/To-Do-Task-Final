import './bootstrap'; // Keeps default Laravel axios settings
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';

const app = createApp(App);

// Initialize Pinia
app.use(createPinia());

app.mount('#app');