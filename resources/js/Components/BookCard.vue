<script setup>
    import { computed } from 'vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        book: {
            type: Object,
            required: true,
            validator: (book) => book && book.id && book.name
        }
    });

    const bookUrl = computed(() => `/books/${props.book.id}`);

    const cardClasses = `
        group relative bg-white/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-200/60 
        hover:border-slate-300/80 hover:bg-white/90 hover:shadow-xl hover:shadow-slate-200/60
        hover:-translate-y-1 transition-all duration-300 ease-out cursor-pointer
    `;

    const gradientClasses = `
        absolute inset-0 bg-gradient-to-br from-blue-50/40 via-slate-50/40 to-transparent 
        opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl
    `;

    const iconWrapperClasses = `
        mb-5 w-12 h-12 bg-gradient-to-br from-slate-200 to-slate-300 rounded-xl 
        flex items-center justify-center group-hover:from-blue-200 group-hover:to-slate-300
        transition-all duration-300 shadow-md group-hover:shadow-lg
    `;

    const titleClasses = `
        text-slate-700 font-medium text-lg leading-relaxed mb-2
        group-hover:text-slate-800 transition-colors duration-300
    `;

    const badgeClasses = 'px-2 py-1 bg-slate-100/60 rounded-md text-xs font-medium';

    const ctaClasses = `
        flex items-center text-slate-400 group-hover:text-slate-600 
        transition-colors duration-300
    `;
</script>

<template>
    <Link 
        :href="bookUrl"
        :class="cardClasses"
        :aria-label="`Lire le livre ${book.name}`">
        
        <div :class="gradientClasses" />
        
        <div class="relative">
            <div :class="iconWrapperClasses">
                <svg 
                    class="w-6 h-6 text-slate-600 group-hover:text-slate-700 transition-colors duration-300" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>

            <h3 :class="titleClasses">
                {{ book.name }}
            </h3>

            <div class="text-sm text-slate-500 mb-4" v-if="book.abbreviation">
                <span :class="badgeClasses">
                    {{ book.abbreviation }}
                </span>
            </div>

            <div :class="ctaClasses">
                <span class="text-sm font-light">Lire les chapitres</span>
                <svg 
                    class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" 
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                    aria-hidden="true">
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="1.5" 
                        d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </div>
    </Link>
</template>