<template>
    <div class="min-h-screen bg-slate-50 font-sans text-slate-900 selection:bg-indigo-100 selection:text-indigo-700">
        <!-- Decorative Background Blob -->
        <div class="fixed top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-50 to-slate-50 -z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Header -->
            <header class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <div class="text-center sm:text-left">
                    <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
                        Task<span class="text-indigo-600">Master</span>
                    </h1>
                    <p class="text-slate-500 text-sm mt-1 font-medium">Focus on what matters most.</p>
                </div>

                <div v-if="auth.isAuthenticated" class="flex items-center gap-4 bg-white/60 backdrop-blur-md px-4 py-2 rounded-full border border-white/50 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs shadow-inner">
                        {{ auth.user.name.charAt(0).toUpperCase() }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-semibold text-slate-700">{{ auth.user.name }}</span>
                        <button @click="handleLogout" class="text-[10px] text-red-500 hover:text-red-600 font-medium text-left transition-colors">
                            Sign out
                        </button>
                    </div>
                </div>
            </header>

            <!-- Auth View -->
            <div v-if="!auth.isAuthenticated" class="max-w-md mx-auto mt-12">
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl shadow-indigo-500/10 border border-white/50 p-8 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                    
                    <div class="flex gap-6 mb-8 border-b border-slate-100 pb-2">
                        <button @click="isLogin = true" class="pb-2 text-sm font-semibold transition-colors relative" :class="isLogin ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">
                            Login
                            <span v-if="isLogin" class="absolute bottom-[-9px] left-0 w-full h-0.5 bg-indigo-600 rounded-t-full"></span>
                        </button>
                        <button @click="isLogin = false" class="pb-2 text-sm font-semibold transition-colors relative" :class="!isLogin ? 'text-indigo-600' : 'text-slate-400 hover:text-slate-600'">
                            Register
                            <span v-if="!isLogin" class="absolute bottom-[-9px] left-0 w-full h-0.5 bg-indigo-600 rounded-t-full"></span>
                        </button>
                    </div>

                    <form @submit.prevent="handleAuth" class="space-y-5">
                        <div v-if="!isLogin" class="space-y-1">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider ml-1">Full Name</label>
                            <input v-model="form.name" type="text" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm" placeholder="John Doe" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider ml-1">Email</label>
                            <input v-model="form.email" type="email" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm" placeholder="you@example.com" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider ml-1">Password</label>
                            <input v-model="form.password" type="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm" placeholder="••••••••" required>
                        </div>
                        <div v-if="!isLogin" class="space-y-1">
                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wider ml-1">Confirm Password</label>
                            <input v-model="form.password_confirmation" type="password" class="w-full px-4 py-3 rounded-xl bg-slate-50 border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all outline-none text-sm" placeholder="••••••••" required>
                        </div>
                        
                        <div v-if="auth.error" class="p-3 rounded-lg bg-red-50 border border-red-100 text-red-600 text-xs font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ auth.error }}
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 transform active:scale-[0.98] transition-all duration-200">
                            {{ isLogin ? 'Sign In' : 'Create Account' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main App View -->
            <div v-else class="space-y-6">
                <!-- Input Card -->
                <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl shadow-indigo-500/5 border border-white/60 p-6 relative overflow-hidden z-10">
                    <TodoForm />
                </div>

                <!-- Controls & List -->
                <div class="bg-white/60 backdrop-blur-md rounded-2xl shadow-lg shadow-slate-200/50 border border-white/50 min-h-[400px] flex flex-col">
                    <!-- Toolbar -->
                    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-4 justify-between items-center bg-white/40 rounded-t-2xl">
                        <div class="relative w-full sm:w-72 group">
                            <input 
                                v-model="filters.search" 
                                @input="debouncedSearch"
                                type="text" 
                                placeholder="Search tasks..." 
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm group-hover:border-slate-300"
                            >
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5 transition-colors group-focus-within:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                            <div class="relative">
                                <select v-model="filters.status" @change="fetchData" class="appearance-none bg-white border border-slate-200 text-slate-600 text-xs font-semibold py-2 pl-3 pr-8 rounded-lg cursor-pointer hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                                    <option value="all">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <svg class="w-3 h-3 text-slate-400 absolute right-2.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>

                            <div class="relative">
                                <select v-model="filters.sort" @change="fetchData" class="appearance-none bg-white border border-slate-200 text-slate-600 text-xs font-semibold py-2 pl-3 pr-8 rounded-lg cursor-pointer hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all shadow-sm">
                                    <option value="created_at">Newest</option>
                                    <option value="due_date">Due Date</option>
                                </select>
                                <svg class="w-3 h-3 text-slate-400 absolute right-2.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- List Content -->
                    <div class="p-4 sm:p-6 flex-1 relative">
                        <!-- Loading -->
                        <div v-if="store.loading && store.todos.length === 0" class="absolute inset-0 flex justify-center items-center bg-white/50 backdrop-blur-sm z-20 rounded-b-2xl">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-xs font-medium text-indigo-600 animate-pulse">Syncing tasks...</span>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else-if="store.todos.length === 0" class="h-full flex flex-col items-center justify-center py-12 text-center">
                            <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4 shadow-inner">
                                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">All caught up!</h3>
                            <p class="text-slate-500 text-sm mt-1 max-w-xs">You have no tasks on your list. Enjoy your free time or add a new task above.</p>
                        </div>

                        <!-- List -->
                        <ul v-else class="space-y-3 relative pb-4">
                            <TransitionGroup name="list">
                                <TodoItem v-for="todo in store.todos" :key="todo.id" :todo="todo" />
                            </TransitionGroup>
                        </ul>
                    </div>
                </div>
            </div>
            
            <footer class="mt-12 text-center">
                <p class="text-slate-400 text-xs font-medium">&copy; {{ new Date().getFullYear() }} TaskMaster. Crafted with Laravel & Vue.</p>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useTodoStore } from './stores/todoStore';
import { useAuthStore } from './stores/authStore';
import TodoForm from './components/TodoForm.vue';
import TodoItem from './components/TodoItem.vue';

const store = useTodoStore();
const auth = useAuthStore();
const isLogin = ref(true);

const filters = reactive({
    search: '',
    status: 'all',
    sort: 'created_at'
});

let timeout = null;
const debouncedSearch = () => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        fetchData();
    }, 300);
};

const fetchData = () => {
    store.fetchTodos(filters);
};

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

const handleAuth = async () => {
    try {
        if (isLogin.value) {
            await auth.login({ email: form.email, password: form.password });
        } else {
            await auth.register(form);
        }
        fetchData();
    } catch (e) {
        // Error handled in store
    }
};

const handleLogout = async () => {
    await auth.logout();
    store.todos = [];
};

onMounted(() => {
    if (auth.isAuthenticated) {
        fetchData();
    }
});
</script>

<style>
/* List Animations */
.list-move,
.list-enter-active,
.list-leave-active {
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.list-leave-active {
  position: absolute;
  width: 100%;
  z-index: 0;
}
</style>