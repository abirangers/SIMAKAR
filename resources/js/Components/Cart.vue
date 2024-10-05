<script setup>
import { formatRupiah } from '@/utils/currency';

defineProps({
    cartItems: Array,
    subtotal: Number,
    tax: Number,
    total: Number,
});

const emit = defineEmits(['updateQuantity', 'removeFromCart', 'checkout']);
</script>

<template>
    <div class="p-4 bg-white">
        <h2 class="text-3xl font-semibold text-gray-800">
            Order #003
        </h2>
        <div class="flex flex-col py-8 border-b border-gray-200 gap-y-6">
            <div v-if="cartItems.length > 0" v-for="item in cartItems" :key="item.id"
                class="flex flex-row items-center justify-between">
                <div class="flex flex-row gap-3">
                    <div class="flex w-20 h-20">
                        <img :src="`/storage/${item.image}`" :alt="item.name"
                            class="object-cover w-full h-full my-auto">
                    </div>
                    <div class="flex flex-col">
                        <p class="w-10 text-lg font-semibold">{{ item.name }}</p>
                        <p class="text-sm font-semibold text-gray-500">{{ formatRupiah(item.price) }}</p>
                    </div>
                </div>
                <div class="flex flex-row items-center gap-x-3">
                    <div class="flex flex-row gap-2">
                        <button @click="emit('updateQuantity', item.id, item.quantity - 1)"
                            class="w-6 h-6 text-xs bg-gray-200 rounded-full pi pi-minus"> </button>
                        <p>{{ item.quantity }}</p>
                        <button @click="emit('updateQuantity', item.id, item.quantity + 1)"
                            class="w-6 h-6 text-xs bg-gray-200 rounded-full pi pi-plus"> </button>
                    </div>
                    <p>{{ formatRupiah(item.price * item.quantity) }}</p>
                    <div class="flex flex-row gap-2">
                        <button @click="emit('removeFromCart', item.id)"
                            class="p-2 text-red-500 bg-red-200 rounded-lg pi pi-trash">
                        </button>
                    </div>
                </div>
            </div>
            <div v-else>
                <p>Tidak ada menu</p>
            </div>
        </div>
        <div class="flex flex-col py-4 border-b border-gray-200 gap-y-2">
            <div class="flex flex-row justify-between">
                <p>Subtotal</p>
                <p class="font-bold">{{ formatRupiah(subtotal) }}</p>
            </div>
            <div class="flex flex-row justify-between">
                <p>Pajak</p>
                <p class="font-bold">{{ formatRupiah(tax) }}</p>
            </div>
        </div>
        <div class="flex flex-row justify-between py-4">
            <p>Total</p>
            <p class="text-xl font-bold">{{ formatRupiah(total) }}</p>
        </div>
        <button @click="emit('checkout')" class="w-full mt-4 btn btn-primary">Checkout</button>
    </div>
</template>
