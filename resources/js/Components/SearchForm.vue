<script setup>
    import { computed } from 'vue';
    import { router } from '@inertiajs/vue3';

    const props = defineProps({
        modelValue: {
            type: String,
            default: ''
        },
        loading: {
            type: Boolean,
            default: false
        },
        context: {
            type: Object,
            default: () => ({})
        }
    });

    const emit = defineEmits(['update:modelValue', 'search', 'filter-change', 'clear']);

    const localQuery = computed({
        get: () => props.modelValue,
        set: (value) => emit('update:modelValue', value)
    });

    const handleSubmit = () => {
        if (localQuery.value.trim()) {
            router.get('/search/results', {
                query: localQuery.value,
                scope: props.context.scope,
            });
        }
    };

    const handleKeydown = (event) => {
        if (event.key === 'Enter') {
            handleSubmit();
        }
    };

    const handleClear = () => {
        localQuery.value = '';
        // Appel à la route sans paramètres pour vider
        router.get('/search/results', {}, {
            preserveState: false
        });
        emit('clear');
    };

    const placeholder = computed(() => {
        if (props.context.scope) {
            return `Rechercher ${props.context.scope}...`;
        }
        return 'Rechercher des versets...';
    });
</script>

<template>
    <div class="space-y-4">
        <div class="flex gap-3">
            <div class="flex-1 relative">
                <input
                    v-model="localQuery"
                    type="text"
                    :placeholder="placeholder"
                    :disabled="loading"
                    @keydown="handleKeydown"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            
            <button
                @click="handleSubmit"
                :disabled="loading || !localQuery.trim()"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
                <svg v-if="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ loading ? 'Recherche...' : 'Rechercher' }}</span>
            </button>
        </div>

        <div v-if="context.scope" class="flex items-center gap-2 text-sm text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Recherche {{ context.scope }}</span>
            <button 
                @click="handleClear"
                class="text-blue-600 hover:text-blue-800 underline ml-2"
            >
                Recherche globale
            </button>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <button 
                    v-if="localQuery"
                    @click="handleClear"
                    class="text-sm text-gray-600 hover:text-gray-800"
                >
                    Effacer
                </button>
            </div>
        </div>

        <div class="text-xs text-gray-500 space-y-1">
            <p><strong>Conseils :</strong> Utilisez * pour les mots partiels (ex: "aim*" trouve "aimer", "aimé")</p>
            <p>Utilisez ? pour remplacer une lettre (ex: "f?mme" trouve "femme")</p>
        </div>
    </div>
</template>