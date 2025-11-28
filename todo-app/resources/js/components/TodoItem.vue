<template>
    <li 
        class="group flex items-start gap-4 p-5 bg-white rounded-xl border transition-all duration-300 relative overflow-hidden"
        :class="[
            isOverdue ? 'border-red-200 bg-red-50/30' : 'border-slate-100 hover:border-indigo-200 hover:shadow-md hover:shadow-indigo-500/5',
            todo.is_completed ? 'opacity-75 bg-slate-50/50' : ''
        ]"
    >
        <!-- Left Accent Bar -->
        <div 
            class="absolute left-0 top-0 bottom-0 w-1 transition-colors duration-300"
            :class="todo.is_completed ? 'bg-slate-200' : (isOverdue ? 'bg-red-400' : 'bg-indigo-500')"
        ></div>

        <!-- Custom Checkbox -->
        <div class="flex-shrink-0 mt-0.5 ml-2">
            <button 
                @click="toggleStatus"
                aria-label="Toggle completion status"
                class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                :class="todo.is_completed 
                    ? 'bg-green-500 border-green-500 scale-105' 
                    : 'border-slate-300 hover:border-indigo-500 bg-white'"
            >
                <svg v-if="todo.is_completed" class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0 cursor-pointer" @click="toggleStatus">
            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                <!-- Category Pill -->
                <span 
                    v-if="todo.category" 
                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide shadow-sm"
                    :style="{ backgroundColor: todo.category.color + '15', color: todo.category.color, border: `1px solid ${todo.category.color}30` }"
                >
                    {{ todo.category.name }}
                </span>
                
                <!-- Due Date Badge -->
                <span 
                    v-if="todo.due_date" 
                    class="flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md border"
                    :class="isOverdue 
                        ? 'text-red-600 bg-red-50 border-red-100' 
                        : 'text-slate-500 bg-slate-50 border-slate-100'"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ formatDueDate(todo.due_date) }}
                </span>
            </div>

            <h4 
                class="text-base font-semibold text-slate-900 truncate transition-all duration-300"
                :class="{'line-through text-slate-400 decoration-slate-300': todo.is_completed}"
            >
                {{ todo.title }}
            </h4>
            
            <p 
                v-if="todo.description" 
                class="mt-1 text-sm text-slate-500 break-words leading-relaxed"
                :class="{'text-slate-300': todo.is_completed}"
            >
                {{ todo.description }}
            </p>
            
            <div class="mt-3 flex items-center gap-2 text-[11px] text-slate-400 font-medium">
                <span>Created {{ formatDate(todo.created_at) }}</span>
            </div>
        </div>

        <!-- Actions (Visible on Hover) -->
        <div class="flex-shrink-0 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-all duration-200 translate-x-2 group-hover:translate-x-0">
            <button 
                @click.stop="deleteItem"
                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-red-500"
                title="Delete task"
                aria-label="Delete task"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </li>
</template>

<script setup>
import { computed } from 'vue';
import { useTodoStore } from '../stores/todoStore';

const props = defineProps({
    todo: { type: Object, required: true }
});

const store = useTodoStore();

const isOverdue = computed(() => {
    if (!props.todo.due_date || props.todo.is_completed) return false;
    return new Date(props.todo.due_date) < new Date();
});

const toggleStatus = () => {
    store.toggleTodo(props.todo);
};

const deleteItem = () => {
    if (confirm('Are you sure you want to delete this task?')) {
        store.deleteTodo(props.todo.id);
    }
};

const formatDueDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const isThisYear = date.getFullYear() === now.getFullYear();
    
    return new Intl.DateTimeFormat('en-US', { 
        month: 'short', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        year: isThisYear ? undefined : 'numeric'
    }).format(date);
};

const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', { 
        month: 'short', 
        day: 'numeric'
    }).format(date);
};
</script>