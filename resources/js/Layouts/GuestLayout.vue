<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex flex-col items-center min-h-screen pt-6 bg-blue-50/70 sm:justify-center sm:pt-0">

        <div class="bg-white border rounded-lg w-96 card">
            <slot />
        </div>
    </div>
</template>