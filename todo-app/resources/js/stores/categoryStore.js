import { defineStore } from 'pinia';
import axios from 'axios';

export const useCategoryStore = defineStore('category', {
    state: () => ({
        categories: [],
        loading: false,
    }),
    actions: {
        async fetchCategories() {
            this.loading = true;
            try {
                const response = await axios.get('/api/categories');
                this.categories = response.data;
            } catch (err) {
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
        async addCategory(name) {
            try {
                const response = await axios.post('/api/categories', { name });
                this.categories.push(response.data);
                return response.data;
            } catch (err) {
                throw err;
            }
        }
    }
});