import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
        error: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        async login(credentials) {
            this.error = null;
            try {
                const response = await axios.post('/api/login', credentials);
                this.setAuth(response.data);
            } catch (err) {
                this.error = err.response?.data?.message || 'Login failed';
                throw err;
            }
        },
        async register(userData) {
            this.error = null;
            try {
                const response = await axios.post('/api/register', userData);
                this.setAuth(response.data);
            } catch (err) {
                this.error = err.response?.data?.message || 'Registration failed';
                throw err;
            }
        },
        async logout() {
            try {
                await axios.post('/api/logout');
            } finally {
                this.clearAuth();
            }
        },
        setAuth(data) {
            this.token = data.access_token;
            this.user = data.user;
            localStorage.setItem('token', this.token);
            localStorage.setItem('user', JSON.stringify(this.user));
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        },
        clearAuth() {
            this.token = null;
            this.user = null;
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            delete axios.defaults.headers.common['Authorization'];
        }
    }
});