<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="label">
        <p class="text-red-600 label-text-alt">
            {{ message }}
        </p>
    </div>
</template>
