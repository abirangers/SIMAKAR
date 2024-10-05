<script setup>
import { ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <input type="file" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="file-input file-input-bordered"/>
</template>