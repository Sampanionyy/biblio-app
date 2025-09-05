<script setup>
    const props = defineProps({
        title: {
            type: String,
            required: true
        },
        message: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            default: 'book' 
        },
        actionLabel: {
            type: String,
            default: null
        },
        actionHref: {
            type: String,
            default: null
        }
    });

    const emit = defineEmits(['action']);

    const icons = {
        book: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        search: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        heart: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
        folder: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z'
    };

    function handleAction() {
        emit('action');
    }
</script>

<template>
    <div class="text-center py-20">
        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-slate-200 to-slate-300 
                    rounded-2xl flex items-center justify-center shadow-lg">
            <svg 
                class="w-10 h-10 text-slate-500" 
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
                aria-hidden="true">
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="1.5"
                    :d="icons[icon] || icons.book" />
            </svg>
        </div>
        
        <h3 class="text-slate-600 font-medium text-xl mb-3">
            {{ title }}
        </h3>
        
        <p class="text-slate-500 text-lg font-light max-w-md mx-auto mb-6">
            {{ message }}
        </p>

        <div v-if="actionLabel" class="mt-8">
            <a 
                v-if="actionHref"
                :href="actionHref"
                class="inline-flex items-center px-6 py-3 bg-slate-600 text-white text-sm font-medium 
                       rounded-xl hover:bg-slate-700 transition-colors duration-200 shadow-lg 
                       hover:shadow-xl transform hover:-translate-y-0.5">
                {{ actionLabel }}
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            
            <button 
                v-else
                @click="handleAction"
                class="inline-flex items-center px-6 py-3 bg-slate-600 text-white text-sm font-medium 
                       rounded-xl hover:bg-slate-700 transition-colors duration-200 shadow-lg 
                       hover:shadow-xl transform hover:-translate-y-0.5">
                {{ actionLabel }}
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
    </div>
</template>