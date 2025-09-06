<script setup>
    import { computed } from 'vue';
    import { Link, router } from '@inertiajs/vue3';
    import Layout from '../../Components/Layout.vue';
    import FooterActions from '../../Components/FooterActions.vue';

    const props = defineProps({
        book: {
            type: Object,
            default: () => ({})
        },
        chapter: {
            type: Object,
            default: () => ({})
        },
        verses: {
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
            label: props.book.name,
            href: `/books/${props.book.id}`
        },
        {
            label: `Chapitre ${props.chapter.number}`
        }
    ]);

    // Computed pour la navigation
    const navigation = computed(() => ({
        prev: props.chapter.number > 1 ? {
            href: `/books/${props.book.id}/chapters/${props.book.id}.${parseInt(props.chapter.number) - 1}`,
            label: 'Chapitre précédent'
        } : null,
        next: {
            href: `/books/${props.book.id}/chapters/${props.book.id}.${parseInt(props.chapter.number) + 1}`,
            label: 'Chapitre suivant'
        },
        back: {
            href: `/books/${props.book.id}`,
            label: 'Retour au livre'
        }
    }));

    const footerActions = computed(() => [
        {
            label: 'Rechercher',
            svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            onClick: () => router.visit("/search")
        }
    ]);
</script>

<template>
    <Layout 
        :title="`${book.name} ${chapter.number}`"
        :subtitle="`${verses.length} verset${verses.length > 1 ? 's' : ''}`"
        :breadcrumbs="breadcrumbs"
        :show-actions="verses.length > 0"
        :navigation="navigation">
        
        <template #content>
            <div v-if="verses.length" class="space-y-4 p-6">
                <Link 
                    v-for="verse in verses" 
                    :key="verse.id" 
                    :href="`/books/${book.id}/chapters/${chapter.id}/verses/${verse.id}`"
                    class="group relative block bg-white/70 backdrop-blur-sm rounded-xl p-6 border border-slate-200/60 
                           hover:border-slate-300/70 hover:bg-white/90 hover:shadow-lg hover:shadow-slate-200/40
                           transition-all duration-300 ease-out cursor-pointer">
                    
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-50/20 via-slate-50/30 to-transparent 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></div>
                    
                    <div class="relative flex items-start space-x-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-slate-100 to-slate-200 
                                    rounded-lg flex items-center justify-center
                                    group-hover:from-blue-100 group-hover:to-slate-200
                                    transition-all duration-300 shadow-sm group-hover:shadow-md">
                            <span class="text-slate-600 font-medium text-sm group-hover:text-slate-700 transition-colors duration-300">
                                {{ (verse.reference).split(":")[1] }} 
                            </span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="mb-2 flex items-center justify-between">
                                <h3 class="text-slate-700 font-medium group-hover:text-slate-800 transition-colors duration-300">
                                    {{ verse.reference }}
                                </h3>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 group-hover:translate-x-1 transition-all duration-300" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>

                            <p v-if="verse.text" class="text-slate-600 font-light leading-relaxed group-hover:text-slate-700 transition-colors duration-300">
                                {{ verse.text }}
                            </p>
                            
                            <div class="mt-3 text-sm text-slate-500 group-hover:text-slate-600 transition-colors duration-300">
                                Cliquer pour lire le verset complet
                            </div>
                        </div>
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
                <h3 class="text-slate-600 font-medium text-xl mb-3">Aucun verset disponible</h3>
                <p class="text-slate-500 text-lg font-light max-w-md mx-auto">
                    Les versets de ce chapitre ne sont pas encore accessibles.
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