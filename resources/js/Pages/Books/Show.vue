<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import Layout from '../../Components/Layout.vue';
import FooterActions from '../../Components/FooterActions.vue';

const props = defineProps({
    book: {
        type: Object,
        default: () => ({})
    },
    chapters: {
        type: Array,
        default: () => []
    }
});

// Computed pour les breadcrumbs
const breadcrumbs = computed(() => [
    {
        label: 'Livres',
        href: '/books'
    },
    {
        label: props.book.name
    }
]);

// Actions pour le footer
const footerActions = computed(() => [
    {
        key: 'search',
        label: 'Rechercher',
        svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        variant: 'default',
        onClick: () => {
            // Action de recherche
        }
    },
    /*{
        key: 'table-contents',
        label: 'Table des matières',
        svgIcon: 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        variant: 'default',
        onClick: () => {
            // Action table des matières
        }
    },
    {
        key: 'favorites',
        label: 'Favoris',
        svgIcon: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
        variant: 'default',
        onClick: () => {
            // Action favoris
        }
    }*/
]);

// Computed pour la navigation (retour aux livres)
const navigation = computed(() => ({
    back: {
        href: '/books',
        label: 'Retour aux livres'
    }
}));
</script>

<template>
    <Layout 
        :title="book.name"
        :subtitle="`${chapters.length} chapitre${chapters.length > 1 ? 's' : ''} disponible${chapters.length > 1 ? 's' : ''}`"
        :breadcrumbs="breadcrumbs"
        :show-actions="chapters.length > 0"
        :navigation="navigation">
        
        <template #content>
            <div v-if="chapters.length" class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 p-6">
                <Link 
                    v-for="chapter in chapters" 
                    :key="chapter.id" 
                    :href="`/books/${book.id}/chapters/${chapter.id}`"
                    class="group relative bg-white/70 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 
                           hover:border-slate-300/80 hover:bg-white/90 hover:shadow-lg hover:shadow-slate-200/50
                           hover:-translate-y-0.5 transition-all duration-250 ease-out cursor-pointer">
                    
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-50/30 via-slate-50/30 to-transparent 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-250 rounded-xl"></div>
                    
                    <div class="relative text-center">
                        <div class="mb-3 w-10 h-10 mx-auto bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg 
                                    flex items-center justify-center group-hover:from-blue-100 group-hover:to-slate-200
                                    transition-all duration-250 shadow-sm group-hover:shadow-md">
                            <span class="text-slate-600 font-medium group-hover:text-slate-700 transition-colors duration-250">
                                {{ chapter.number }}
                            </span>
                        </div>

                        <h3 class="text-slate-700 font-medium text-sm leading-relaxed
                                   group-hover:text-slate-800 transition-colors duration-250">
                            Chapitre {{ chapter.number }}
                        </h3>

                        <p v-if="chapter.reference" class="text-xs text-slate-500 mt-1 font-light">
                            {{ chapter.reference }}
                        </p>
                    </div>
                </Link>
            </div>

            <div v-else class="text-center py-20">
                <div class="w-18 h-18 mx-auto mb-6 bg-gradient-to-br from-slate-200 to-slate-300 
                            rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-slate-600 font-medium text-xl mb-3">Aucun chapitre disponible</h3>
                <p class="text-slate-500 text-lg font-light max-w-md mx-auto">
                    Les chapitres de ce livre ne sont pas encore accessibles.
                </p>
            </div>
        </template>

        <template #actions>
            <FooterActions 
                :actions="footerActions" 
                size="md"
                alignment="center" />
        </template>
    </Layout>
</template>