<script setup>
import { formatRupiah } from '@/utils/currency';
import { computed } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: [Number, String],
        required: true
    },
    icon: {
        type: String,
        required: true
    },
    color: {
        type: String,
        default: 'blue'
    },
    formatValue: {
        type: Boolean,
        default: false
    }
});

const formattedValue = computed(() => {
    return props.formatValue ? formatRupiah(props.value) : props.value;
});

const iconClasses = computed(() => {
    return `flex items-center justify-center w-[52px] h-[52px] text-${props.color}-500 bg-${props.color}-100 rounded-full`;
});
</script>

<template>
    <div class="p-6 bg-white rounded-lg shadow-sm">
        <div class="flex items-center">
            <div :class="iconClasses">
                <i :class="`text-2xl pi ${icon}`"></i>
            </div>
            <div class="ml-4">
                <p class="mb-2 text-sm font-medium text-gray-600">{{ title }}</p>
                <p class="text-lg font-semibold text-gray-700">{{ formattedValue }}</p>
            </div>
        </div>
    </div>
</template>
