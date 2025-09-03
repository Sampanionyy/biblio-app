<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    books: {
        type: Array,
        default: () => []
    },
    loading: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Livres'
    }
});
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100">
        <!-- Header avec effet de plume -->
        <div class="relative overflow-hidden bg-white/70 backdrop-blur-sm border-b border-slate-200/50 shadow-sm">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-100/20 to-transparent"></div>
            <div class="relative max-w-4xl mx-auto px-6 py-8">
                <h1 class="text-3xl font-light text-slate-800 tracking-wide">
                    {{ title }}
                </h1>
                <div class="mt-2 w-16 h-0.5 bg-gradient-to-r from-slate-300 to-transparent rounded-full"></div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- État de chargement -->
            <div v-if="loading" class="flex items-center justify-center py-12">
                <div class="flex items-center space-x-3 text-slate-500">
                    <div class="animate-spin rounded-full h-6 w-6 border-2 border-slate-300 border-t-slate-600"></div>
                    <span class="font-light">Chargement en cours...</span>
                </div>
            </div>

            <!-- Liste des livres -->
            <div v-else-if="books.length" class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="book in books" :key="book.id" class="group relative bg-white/60 backdrop-blur-sm rounded-xl p-6 border border-slate-200/50 
                 hover:border-slate-300/70 hover:bg-white/80 hover:shadow-lg hover:shadow-slate-200/50
                 transition-all duration-300 ease-in-out cursor-pointer">
                    <!-- Effet de survol subtil -->
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-50/50 to-transparent 
                      opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>

                    <div class="relative">
                        <!-- Icône livre -->
                        <div class="mb-3 w-8 h-8 bg-gradient-to-br from-slate-200 to-slate-300 rounded-lg 
                        flex items-center justify-center group-hover:from-slate-300 group-hover:to-slate-400
                        transition-all duration-300">
                            <svg class="w-4 h-4 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <!-- Titre du livre -->
                        <h3 class="text-slate-700 font-medium leading-relaxed group-hover:text-slate-800 
                       transition-colors duration-300">
                            {{ book.name }}
                        </h3>

                        <!-- Métadonnées optionnelles -->
                        <div v-if="book.author || book.year" class="mt-2 text-sm text-slate-500 space-y-1">
                            <p v-if="book.author">{{ book.author }}</p>
                            <p v-if="book.year" class="text-xs">{{ book.year }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- État vide -->
            <div v-else class="text-center py-16">
                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-slate-200 to-slate-300 
                    rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-slate-600 font-medium mb-2">Aucun livre disponible</h3>
                <p class="text-slate-500 text-sm">Votre bible semble être vide pour le moment.</p>
            </div>
        </div>
    </div>
</template>