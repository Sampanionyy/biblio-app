<script setup>
    import { defineProps, defineSlots } from 'vue';
    import { Link } from '@inertiajs/vue3';
    import { Head } from '@inertiajs/vue3';
    import { Toaster } from '@/components/ui/sonner'
    import 'vue-sonner/style.css'
    
    const props = defineProps({
        title: {
            type: String,
            default: ''
        },
        subtitle: {
            type: String,
            default: ''
        },
        breadcrumbs: {
            type: Array,
            default: () => []
        },
        showActions: {
            type: Boolean,
            default: false
        },
        navigation: {
            type: Object,
            default: () => ({})
        }
    });

    const slots = defineSlots();
</script>

<template>
    <Head :title="`Bible/${title}`" />
    <div class="min-h-screen bg-gray-50">
        <header class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-4">
                    <nav v-if="breadcrumbs.length" class="flex items-center space-x-2 text-sm text-gray-500">
                        <template v-for="(crumb, index) in breadcrumbs" :key="index">
                            <Link v-if="crumb.href && index < breadcrumbs.length - 1" 
                                  :href="crumb.href" 
                                  class="hover:text-gray-700 transition-colors flex items-center">
                                <component v-if="crumb.icon" :is="crumb.icon" class="w-4 h-4 mr-1" />
                                {{ crumb.label }}
                            </Link>
                            <span v-else-if="index < breadcrumbs.length - 1" 
                                  class="hover:text-gray-700 transition-colors flex items-center">
                                <component v-if="crumb.icon" :is="crumb.icon" class="w-4 h-4 mr-1" />
                                {{ crumb.label }}
                            </span>
                            <span v-if="index < breadcrumbs.length - 1" class="text-gray-300">/</span>
                            <span v-if="index === breadcrumbs.length - 1" class="text-gray-900 font-medium">
                                {{ crumb.label }}
                            </span>
                        </template>
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 v-if="title" class="text-2xl font-semibold text-gray-900">{{ title }}</h1>
                    <p v-if="subtitle" class="mt-1 text-sm text-gray-600">{{ subtitle }}</p>
                </div>
                
                <div v-if="slots.headerActions" class="flex items-center space-x-3">
                    <slot name="headerActions" />
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <slot name="content" />
                
                <div v-if="!slots.content" class="p-8">
                    <slot />
                </div>
            </div>

            <div v-if="showActions && slots.actions" class="mt-6 flex justify-center">
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <slot name="actions" />
                </div>
            </div>

            <div v-if="navigation.prev || navigation.next || navigation.back" class="mt-8 flex items-center justify-between">
                <div class="flex-1">
                    <Link v-if="navigation.prev" 
                          :href="navigation.prev.href"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        {{ navigation.prev.label }}
                    </Link>
                </div>

                <div class="flex-shrink-0 mx-4">
                    <Link v-if="navigation.back" 
                          :href="navigation.back.href"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ navigation.back.label }}
                    </Link>
                </div>

                <div class="flex-1 flex justify-end">
                    <Link v-if="navigation.next" 
                          :href="navigation.next.href"
                          class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        {{ navigation.next.label }}
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>
            </div>
        </main>
    </div>
    <Toaster />
</template>