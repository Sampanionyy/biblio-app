<script setup>
    import { computed, shallowRef } from 'vue';
    import Layout from '../../Components/Layout.vue';
    import FooterActions from '../../Components/FooterActions.vue';
    import BookCard from '../../Components/BookCard.vue';
    import EmptyState from '../../Components/EmptyState.vue';

    const props = defineProps({
        books: {
            type: Array,
            default: () => [],
            validator: (books) => Array.isArray(books)
        },
        loading: {
            type: Boolean,
            default: false
        }
    });

    const breadcrumbs = shallowRef([
        { label: 'Livres' }
    ]);

    const footerActions = computed(() => [
        {
            key: 'global-search',
            label: 'Recherche globale',
            svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            variant: 'default',
            onClick: handleGlobalSearch
        }
    ]);

    const navigation = {};

    const gridClasses = 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-6';

    function handleGlobalSearch() {
        // Action de recherche globale
        console.log('Recherche globale déclenchée');
    }

    const showActions = computed(() => props.books.length > 0 && !props.loading);

    const layoutProps = computed(() => ({
        title: "Sainte Bible",
        subtitle: "Explorez les écritures sacrées, livre par livre",
        breadcrumbs: breadcrumbs.value,
        showActions: showActions.value,
        navigation
    }));
</script>

<template>
    <Layout v-bind="layoutProps">
        <template #content>
            <div 
                v-if="books.length" 
                :class="gridClasses">
                <BookCard
                    v-for="book in books"
                    :key="book.id"
                    :book="book" />
            </div>

            <EmptyState 
                v-else
                title="Aucune écriture disponible"
                message="Les livres sacrés ne sont pas encore accessibles. Veuillez réessayer plus tard." />
        </template>

        <template #actions>
            <FooterActions 
                :actions="footerActions" 
                size="md"
                alignment="center" />
        </template>
    </Layout>
</template>