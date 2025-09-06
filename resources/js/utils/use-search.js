// composables/useSearch.js
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

export function useSearch() {
    const searchQuery = ref('');
    const isSearching = ref(false);

    const handleGlobalSearch = async (query = null) => {
        const searchTerm = query || searchQuery.value;
        
        if (!searchTerm?.trim()) {
            router.visit('/search');
            return;
        }

        isSearching.value = true;
        
        try {
            router.visit('/search', {
                data: { q: searchTerm.trim() },
                preserveState: true,
                replace: false
            });
        } finally {
            isSearching.value = false;
        }
    };

    const handleContextualSearch = async (context = {}) => {
        const params = {
            q: searchQuery.value?.trim() || '',
            ...context
        };

        if (!params.q) {
            router.visit('/search', { data: context });
            return;
        }

        isSearching.value = true;
        
        try {
            router.visit('/search', {
                data: params,
                preserveState: true
            });
        } finally {
            isSearching.value = false;
        }
    };

    const getSearchActions = (context = {}) => {
        const actions = [];

        actions.push({
            key: 'global-search',
            label: 'Recherche globale',
            svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            variant: 'default',
            onClick: () => handleGlobalSearch(),
            loading: isSearching.value
        });

        if (Object.keys(context).length > 0) {
            actions.push({
                key: 'contextual-search',
                label: getContextualSearchLabel(context),
                svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                variant: 'secondary',
                onClick: () => handleContextualSearch(context),
                loading: isSearching.value
            });
        }

        return actions;
    };

    const getContextualSearchLabel = (context) => {
        if (context.bookId && context.chapterId) {
            return 'Rechercher dans ce chapitre';
        }
        if (context.bookId) {
            return 'Rechercher dans ce livre';
        }
        return 'Rechercher ici';
    };

    return {
        searchQuery,
        isSearching,
        handleGlobalSearch,
        handleContextualSearch,
        getSearchActions
    };
}