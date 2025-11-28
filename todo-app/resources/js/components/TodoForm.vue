<template>
    <form @submit.prevent="submitForm" class="space-y-5">
        <div class="grid grid-cols-1 gap-5">
            <!-- Title Input with Floating Label -->
            <div class="relative group">
                <input 
                    v-model="form.title" 
                    type="text" 
                    id="title"
                    placeholder=" "
                    class="peer w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm"
                    :class="{'border-red-300 focus:ring-red-500/20 focus:border-red-500': errors.title}"
                >
                <label 
                    for="title" 
                    class="absolute left-4 -top-2.5 bg-white px-1 text-xs font-semibold text-indigo-600 transition-all 
                           peer-placeholder-shown:top-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-slate-400 peer-placeholder-shown:bg-transparent
                           peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-indigo-600 peer-focus:bg-white rounded-md"
                >
                    What needs to be done?
                </label>
                <p v-if="errors.title" class="mt-1 text-xs text-red-500 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ errors.title[0] }}
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <!-- Category Select -->
                <div class="w-full sm:w-1/3 relative">
                    <select 
                        v-model="form.category_id" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-700 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm appearance-none transition-all cursor-pointer"
                    >
                        <option :value="null">No Category</option>
                        <option v-for="cat in categoryStore.categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <!-- Due Date Input -->
                <div class="w-full sm:w-1/3 relative">
                    <input 
                        v-model="form.due_date"
                        type="datetime-local"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-600 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 shadow-sm transition-all"
                    >
                </div>

                <!-- Quick Add Category -->
                <div class="flex-1 flex gap-2">
                    <input 
                        v-model="newCategoryName" 
                        type="text" 
                        placeholder="New Tag..." 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                        @keydown.enter.prevent="createNewCategory"
                    >
                    <button 
                        @click.prevent="createNewCategory"
                        type="button"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-indigo-100 hover:text-indigo-600 transition-colors border border-slate-200"
                        :disabled="!newCategoryName"
                        title="Add Category"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Description Input -->
            <div class="relative">
                <textarea 
                    v-model="form.description" 
                    id="description"
                    rows="2"
                    placeholder=" "
                    class="peer w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50/50 text-slate-900 placeholder-transparent focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm resize-none"
                ></textarea>
                <label 
                    for="description" 
                    class="absolute left-4 -top-2.5 bg-white px-1 text-xs font-semibold text-slate-400 transition-all 
                           peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-sm peer-placeholder-shown:text-slate-400 peer-placeholder-shown:bg-transparent
                           peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-indigo-600 peer-focus:bg-white rounded-md"
                >
                    Details (optional)
                </label>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button 
                type="submit" 
                :disabled="store.loading || !form.title"
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform active:scale-95"
            >
                <svg v-if="store.loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span v-else class="mr-2 text-lg leading-none">+</span>
                Add Task
            </button>
        </div>
    </form>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useTodoStore } from '../stores/todoStore';
import { useCategoryStore } from '../stores/categoryStore';

const store = useTodoStore();
const categoryStore = useCategoryStore();
const errors = ref({});
const newCategoryName = ref('');

const form = reactive({
    title: '',
    description: '',
    category_id: null,
    due_date: ''
});

onMounted(() => {
    categoryStore.fetchCategories();
});

const createNewCategory = async () => {
    if (!newCategoryName.value) return;
    try {
        const newCat = await categoryStore.addCategory(newCategoryName.value);
        form.category_id = newCat.id;
        newCategoryName.value = '';
    } catch (e) {
        console.error(e);
    }
};

const submitForm = async () => {
    errors.value = {};
    try {
        await store.addTodo(form);
        form.title = '';
        form.description = '';
        form.due_date = '';
    } catch (err) {
        if (err.response && err.response.status === 422) {
            errors.value = err.response.data.errors;
        }
    }
};
</script>