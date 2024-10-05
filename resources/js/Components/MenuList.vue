<script setup>
import { formatRupiah } from '@/utils/currency';

defineProps({
    menus: Array,
});

const emit = defineEmits(['addToCart']);
</script>

<template>
    <div class="grid grid-cols-3 gap-4 mt-4">
        <div v-if="menus.length > 0" v-for="menu in menus" :key="menu.id" 
             class="p-6 text-center transition-all duration-300 bg-white cursor-pointer card hover:border hover:border-primary" 
             @click="emit('addToCart', menu)">
            <div class="h-24 mx-auto">
                <img :src="`/storage/${menu.image}`" :alt="menu.name" class="object-cover w-full h-full">
            </div>
            <h4 class="mt-4 mb-2 text-xl font-bold text-center">{{ menu.name }}</h4>
            <div class="flex flex-row justify-center gap-1">
                <p class="mb-0 text-gray-500">{{ menu.category.name }}</p>
                <p class="mb-0 font-bold text-primary">{{ formatRupiah(menu.price) }}</p>
            </div>
        </div>
        <div v-else>
            <p>Tidak ada menu</p>
        </div>
    </div>
</template>
