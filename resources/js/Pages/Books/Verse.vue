<script setup>
    import { defineProps, computed } from 'vue';
    import Layout from '../../Components/Layout.vue';
    import FooterActions from '../../Components/FooterActions.vue';
    import { toast } from 'vue-sonner'
    import { format } from "date-fns"
    import { fr } from 'date-fns/locale';
    import { router } from '@inertiajs/vue3';

    const currentDate = format(new Date(), "EEEE dd MMMM yyyy 'à' HH:mm", {
        locale: fr,
    });
    
    const cleanContent = (html) => {
        return html
            .replace(/<[^>]+>/g, '')   
            .trim();                   
    };

    const props = defineProps({
        book: {
            type: Object,
            default: () => ({})
        },
        chapter: {
            type: Object,
            default: () => ({})
        },
        verse: {
            type: Object,
            default: () => ({})
        }
    });

    // Computed pour les breadcrumbs
    const breadcrumbs = computed(() => [
        {
            label: 'Livres',
            href: '/books',
            icon: 'HomeIcon'
        },
        {
            label: props.book.name,
            href: `/books/${props.book.id}`
        },
        {
            label: `Chapitre ${props.chapter.number}`,
            href: `/books/${props.book.id}/chapters/${props.chapter.id}`
        },
        {
            label: `Verset ${(props.verse.reference).split(":")[1]}`
        }
    ]);

    const navigation = computed(() => ({
        prev: props.verse.number > 1 ? {
            href: `/books/${props.book.id}/chapters/${props.chapter.id}/verses/${props.book.id}.${props.chapter.number}.${parseInt(props.verse.number) - 1}`,
            label: 'Verset précédent'
        } : null,
        next: {
            href: `/books/${props.book.id}/chapters/${props.chapter.id}/verses/${props.book.id}.${props.chapter.number}.${parseInt(props.verse.number) + 1}`,
            label: 'Verset suivant'
        },
        back: {
            href: `/books/${props.book.id}/chapters/${props.chapter.id}`,
            label: 'Retour au chapitre'
        }
    }));

    const footerActions = computed(() => [
        /*{
            key: 'share',
            label: 'Partager',
            svgIcon: 'M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z',
            onClick: () => handleShare(),
            tooltip: 'Partager ce verset'
        },
        {
            key: 'favorite',
            label: 'Favoris',
            svgIcon: 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
            onClick: () => handleFavorite(),
            tooltip: 'Ajouter aux favoris'
        },*/
        {
            key: 'search',
            label: 'Rechercher',
            svgIcon: 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
            onClick: () => router.visit("/search"),
            tooltip: 'Rechercher dans la Bible'
        },
        {
            key: 'copy',
            label: 'Copier',
            svgIcon: 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z',
            onClick: () => handleCopy(),
            tooltip: 'Copier le texte'
        }
    ]);

    const handleShare = () => {
        if (navigator.share) {
            navigator.share({
                title: props.verse.reference,
                text: cleanContent(props.verse.content || props.verse.text),
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            toast('Lien copié dans le presse-papiers', {
                description: currentDate,
                action: {
                    label: 'Fermer',
                },
            })
        }
    };

    /*const handleFavorite = () => {
        console.log('Toggle favorite for verse:', props.verse.id);
    };*/

    const handleCopy = () => {
        const text = cleanContent(props.verse.content || props.verse.text);
        navigator.clipboard.writeText(`"${text}" - ${props.verse.reference}`);
        toast('Verset copié avec succès', {
            description: currentDate,
            action: {
                label: 'Fermer'
            },
        })    
    };

    /*const handleActionClick = ({ action, index }) => {
        console.log('Action clicked:', action.key, 'at index:', index);
    }; */
</script>

<template>
    <Layout 
        :title="verse.reference"
        :subtitle="`${book.name} - Chapitre ${chapter.number}`"
        :breadcrumbs="breadcrumbs"
        :show-actions="!!(verse.content || verse.text)"
        :navigation="navigation">
        
        <template #content>
            <div v-if="verse.content || verse.text" class="p-8 text-center">
                <div class="max-w-3xl mx-auto">
                    <blockquote class="text-xl md:text-2xl text-gray-700 leading-relaxed mb-6 relative">
                        <span class="text-6xl text-gray-200 absolute -top-4 -left-4 font-serif">"</span>
                        <span class="relative italic">{{ cleanContent(verse.content) || "" }}</span>
                        <span class="text-6xl text-gray-200 absolute -bottom-8 -right-4 font-serif">"</span>
                    </blockquote>
                    
                    <cite class="text-gray-500 font-medium not-italic">
                        {{ verse.reference }}
                    </cite>
                </div>
            </div>

            <div v-else class="p-16 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <h3 class="text-gray-900 font-medium text-lg mb-2">Verset non disponible</h3>
                <p class="text-gray-500 max-w-sm mx-auto">
                    Le contenu de ce verset n'est pas encore accessible.
                </p>
            </div>
        </template>

        <template #actions>
            <FooterActions
                :actions="footerActions"
                alignment="left"
                size="md"
                @action-click="handleActionClick"
            />
        </template>
    </Layout>
</template>