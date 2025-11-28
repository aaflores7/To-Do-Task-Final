import { defineStore } from 'pinia';
import axios from 'axios';

export const useTodoStore = defineStore('todo', {
    state: () => ({
        todos: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchTodos(params = {}) {
            this.loading = true;
            this.error = null;
            try {
                // params: { sort, search, status }
                const response = await axios.get('/api/todos', {
                    params: params
                });
                this.todos = response.data;
            } catch (err) {
                if (err.response?.status === 401) {
                    this.error = 'Please login to view your tasks';
                } else {
                    this.error = err.response?.data?.message || 'Failed to load todos';
                }
                console.error('Fetch error:', err.response?.data || err.message);
            } finally {
                this.loading = false;
            }
        },

        async addTodo(todoData) {
            this.error = null;
            try {
                const response = await axios.post('/api/todos', todoData);
                this.todos.unshift(response.data);
            } catch (err) {
                this.error = err.response?.data?.message || 'Failed to add todo';
                throw err;
            }
        },

        async toggleTodo(todo) {
            try {
                todo.is_completed = !todo.is_completed;
                await axios.put(`/api/todos/${todo.id}`, {
                    is_completed: todo.is_completed
                });
            } catch (err) {
                todo.is_completed = !todo.is_completed;
                this.error = 'Failed to update status';
                console.error(err);
            }
        },

        async deleteTodo(id) {
            try {
                await axios.delete(`/api/todos/${id}`);
                this.todos = this.todos.filter(t => t.id !== id);
            } catch (err) {
                this.error = 'Failed to delete todo';
                console.error(err);
            }
        }
    }
});