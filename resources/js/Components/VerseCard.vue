<script setup>
    import { computed } from 'vue';
    import { Link } from '@inertiajs/vue3';

    const props = defineProps({
        verse: {
            type: Object,
            required: true
        },
        highlightQuery: {
            type: String,
            default: ''
        }
    });

    const reference = computed(() => {
        const ref = props.verse.reference || props.verse.id || '';
        const parts = ref.split('.');
        
        if (parts.length >= 3) {
            return {
                book: props.verse.bookId || parts[0],
                chapter: parts[1],
                verse: parts[2],
                display: `${props.verse.bookName || parts[0]} ${parts[1]}:${parts[2]}`
            };
        }
        
        return {
            book: props.verse.bookId || '',
            chapter: '',
            verse: '',
            display: ref
        };
    });

    const highlightedText = computed(() => {
        if (!props.highlightQuery || !props.verse.text) {
            return props.verse.text || '';
        }

        const query = props.highlightQuery.trim();
        if (!query) return props.verse.text;

        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        
        const regex = new RegExp(`(${escapedQuery})`, 'gi');
        
        return props.verse.text.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
    });

    const chapterLink = computed(() => {
        if (reference.value.book && reference.value.chapter) {
            return `/books/${reference.value.book}/chapters/${reference.value.chapter}`;
        }
        return null;
    });

    const verseLink = computed(() => {
        if (chapterLink.value && reference.value.verse) {
            return `${chapterLink.value}#verse-${reference.value.verse}`;
        }
        return chapterLink.value;
    });

</script>

<template>
    <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-4">
            <div>
                <Link 
                    v-if="verseLink" 
                    :href="verseLink"
                    class="text-lg font-semibold text-blue-600 hover:text-blue-800 hover:underline"
                >
                    {{ reference.display }}
                </Link>
                <h3 v-else class="text-lg font-semibold text-gray-900">
                    {{ reference.display }}
                </h3>
                
                <div v-if="verse.bookName" class="text-sm text-gray-500 mt-1">
                    {{ verse.bookName }}
                    <span v-if="verse.chapterNumber"> - Chapitre {{ verse.chapterNumber }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button 
                    class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100"
                    title="Marquer ce verset"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="prose prose-sm max-w-none">
            <p 
                class="text-gray-800 leading-relaxed text-base"
                v-html="highlightedText"
            ></p>
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center gap-4 text-sm text-gray-500">
                <span v-if="verse.score" class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    {{ Math.round(verse.score * 100) }}%
                </span>
            </div>

            <div class="flex items-center gap-2">
                <Link 
                    v-if="chapterLink"
                    :href="chapterLink"
                    class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1"
                >
                    Voir le contexte
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </Link>
            </div>
        </div>
    </div>
</template>