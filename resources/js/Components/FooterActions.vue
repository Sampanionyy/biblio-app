<script setup>
    import { defineProps, defineEmits } from 'vue';

    const props = defineProps({
        actions: {
            type: Array,
            default: () => []
        },
        variant: {
            type: String,
            default: 'default', 
            validator: (value) => ['default', 'primary', 'minimal'].includes(value)
        },
        size: {
            type: String,
            default: 'md', 
            validator: (value) => ['sm', 'md', 'lg'].includes(value)
        },
        alignment: {
            type: String,
            default: 'left', 
            validator: (value) => ['left', 'center', 'right', 'space-between'].includes(value)
        },
        fullWidth: {
            type: Boolean,
            default: false
        }
    });

    const emit = defineEmits(['action-click']);

    const handleActionClick = (action, index) => {
        if (action.onClick) {
            action.onClick();
        }
        emit('action-click', { action, index });
    };

    const getButtonClasses = (action) => {
        const baseClasses = 'inline-flex items-center border rounded-md shadow-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors';
        
        const sizeClasses = {
            sm: 'px-3 py-1.5 text-xs',
            md: 'px-4 py-2 text-sm',
            lg: 'px-6 py-3 text-base'
        };
        
        let variantClasses = 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-indigo-500';
        
        if (action.variant === 'primary') {
            variantClasses = 'border-transparent text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500';
        } else if (action.variant === 'danger') {
            variantClasses = 'border-transparent text-white bg-red-600 hover:bg-red-700 focus:ring-red-500';
        } else if (action.variant === 'success') {
            variantClasses = 'border-transparent text-white bg-green-600 hover:bg-green-700 focus:ring-green-500';
        } else if (action.variant === 'minimal') {
            variantClasses = 'border-transparent text-gray-500 bg-transparent hover:text-gray-700 hover:bg-gray-50 focus:ring-gray-500';
        }
        
        const widthClasses = props.fullWidth ? 'w-full justify-center' : '';
        
        return `${baseClasses} ${sizeClasses[props.size]} ${variantClasses} ${widthClasses} ${action.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'}`;
    };

    const getContainerClasses = () => {
        const baseClasses = 'flex gap-3';
        
        const alignmentClasses = {
            left: 'justify-start',
            center: 'justify-center',
            right: 'justify-end',
            'space-between': 'justify-between'
        };
        
        const responsiveClasses = props.fullWidth ? 'flex-col sm:flex-row' : '';
        
        return `${baseClasses} ${alignmentClasses[props.alignment]} ${responsiveClasses}`;
    };
</script>

<template>
    <div v-if="actions.length > 0" :class="getContainerClasses()">
        <button
            v-for="(action, index) in actions"
            :key="action.key || index"
            :class="getButtonClasses(action)"
            :disabled="action.disabled"
            :title="action.tooltip"
            @click="handleActionClick(action, index)"
        >
            <component
                v-if="action.icon"
                :is="action.icon"
                :class="[
                    action.label ? 'mr-2' : '',
                    size === 'sm' ? 'w-3 h-3' : size === 'lg' ? 'w-5 h-5' : 'w-4 h-4'
                ]"
            />
            
            <svg
                v-else-if="action.svgIcon"
                :class="[
                    action.label ? 'mr-2' : '',
                    size === 'sm' ? 'w-3 h-3' : size === 'lg' ? 'w-5 h-5' : 'w-4 h-4'
                ]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    :d="action.svgIcon"
                />
            </svg>
            
            <span v-if="action.label">{{ action.label }}</span>
            
            <span
                v-if="action.badge"
                :class="[
                    'ml-2 inline-flex items-center justify-center px-2 py-1 text-xs font-medium rounded-full',
                    action.badgeVariant === 'danger' ? 'bg-red-100 text-red-800' : 
                    action.badgeVariant === 'success' ? 'bg-green-100 text-green-800' : 
                    action.badgeVariant === 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                    'bg-gray-100 text-gray-800'
                ]"
            >
                {{ action.badge }}
            </span>
        </button>
    </div>
</template>