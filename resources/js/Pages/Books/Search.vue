<script setup>
    import { computed, ref, watch } from 'vue';
    import { router } from '@inertiajs/vue3';
    import Layout from '@/Components/Layout.vue';
    import FooterActions from '@/Components/FooterActions.vue';
    import VerseCard from '@/Components/VerseCard.vue';
    import EmptyState from '@/Components/EmptyState.vue';
    import SearchForm from '@/Components/SearchForm.vue';

    const props = defineProps({
        query: {
            type: String,
            default: ''
        },
        results: {
            type: Array,
            default: () => []
        }
    });

    const searchQuery = ref(props.query || '');
    const isSearching = ref(false);

    const breadcrumbs = computed(() => {
        const crumbs = [
            { label: 'Livres', href: '/' },
            { label: 'Recherche' }
        ];

        return crumbs;
    });

    const pageTitle = computed(() => {
        if (props.query) {
            return `Recherche : "${props.query}"`;
        }
        return 'Recherche dans les Écritures';
    });

    const pageSubtitle = computed(() => {
        return 'Trouvez des versets par mots-clés, références ou phrases';
    });

    const footerActions = computed(() => {
        const actions = [];
        
        if (props.results && props.results.length > 0) {
            actions.push({
                key: 'new-search',
                label: 'Nouvelle recherche',
                svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                variant: 'secondary',
                onClick: () => clearSearch()
            });
        }

        return actions;
    });

    const performSearch = () => {
        const query = searchQuery.value.trim();
        
        if (!query) return;
        
        isSearching.value = true;
        
        const params = {
            q: query
        };

        router.visit('/search', {
            data: params,
            preserveState: false,
            onFinish: () => {
                isSearching.value = false;
            }
        });
    };

    const clearSearch = () => {
        searchQuery.value = '';
        router.visit('/search', {
            data: {
                type: props.searchParams.type || 'global',
                bookId: selectedFilters.value.bookId,
                chapterId: selectedFilters.value.chapterId
            }
        });
    };

    const handleFilterChange = (filters) => {
        selectedFilters.value = { ...selectedFilters.value, ...filters };
        if (searchQuery.value.trim()) {
            performSearch();
        }
    };

    // Props pour le Layout
    const layoutProps = computed(() => ({
        title: pageTitle.value,
        subtitle: pageSubtitle.value,
        breadcrumbs: breadcrumbs.value,
        showActions: footerActions.value.length > 0
    }));

    // Classes CSS
    const gridClasses = 'space-y-4 p-6';
    const showActions = computed(() => footerActions.value.length > 0);
    const totalResults = computed(() => props.results.length);
</script>

<template>
    <Layout v-bind="layoutProps">
        <template #content>
            <div class="border-b border-gray-200 bg-gray-50 p-6">
                <SearchForm
                    v-model="searchQuery"
                    :loading="isSearching"
                    :filters="selectedFilters"
                    @search="performSearch"
                    @filter-change="handleFilterChange"
                    @clear="clearSearch"
                />
            </div>

            <div v-if="results" :class="gridClasses">
                <div class="mb-4 text-sm text-gray-600">
                    {{ totalResults }} résultat{{ totalResults > 1 ? 's' : '' }}
                </div>
                
                <VerseCard
                    v-for="verse in results.verses"
                    :key="verse.id"
                    :verse="verse"
                    :highlight-query="query"
                    class="mb-4"
                />
            </div>

            <EmptyState 
                v-else-if="results && results.length === 0 && query"
                title="Aucun verset trouvé"
                :message="`Aucun résultat pour '${query}'. Essayez avec d'autres mots-clés ou vérifiez l'orthographe.`">
                <template #actions>
                    <button 
                        @click="clearSearch"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Nouvelle recherche
                    </button>
                </template>
            </EmptyState>

            <!-- État initial (pas de recherche) -->
            <EmptyState 
                v-else-if="!query"
                title="Rechercher dans les Écritures"
                :message="'Saisissez des mots-clés, une référence ou une phrase pour commencer'">
                <template #icon>
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </template>
            </EmptyState>
        </template>

        <template #actions v-if="showActions">
            <FooterActions 
                :actions="footerActions" 
                size="md"
                alignment="center" />
        </template>
    </Layout>
</template>