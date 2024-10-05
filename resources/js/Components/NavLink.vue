<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'active flex items-center'
        : 'hover:bg-neutral hover:text-neutral-content flex items-center',
);
</script>

<template>
    <li class="my-auto">
        <Link :href="href" :class="classes">
        <slot />
        </Link>
    </li>
</template>
