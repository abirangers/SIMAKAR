<script setup>
import { formatRupiah } from '@/utils/currency';

defineProps({
    order: {
        type: Object,
        required: true,
    },
});

defineEmits(['close']);
</script>

<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Detail Pesanan
        </h2>
        <div class="mt-4">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Kode Pesanan:</span>
                <span>{{ order.order_code }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Nama Kasir:</span>
                <span>{{ order.user.name }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Nama Pelanggan:</span>
                <span>{{ order.customer_name }}</span>
            </div>
        </div>
        <div class="mt-4">
            <h3 class="mb-2 font-medium text-gray-900 text-md">Items:</h3>
            <div v-for="item in order.order_items" :key="item.id" class="flex justify-between mb-1">
                <span>{{ item.menu.name }}</span>
                <span>{{ item.quantity }} x {{ formatRupiah(item.menu.price) }}</span>
            </div>
        </div>
        <div class="pt-4 mt-4 border-t border-gray-200">
            <div class="flex justify-between">
                <span class="font-semibold">Subtotal:</span>
                <span class="font-semibold">{{ formatRupiah(order.subtotal) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Pajak:</span>
                <span class="font-semibold">{{ formatRupiah(order.tax) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Total:</span>
                <span class="font-semibold">{{ formatRupiah(order.total) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Tunai:</span>
                <span class="font-semibold">{{ formatRupiah(order.cash) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-semibold">Kembalian:</span>
                <span class="font-semibold">{{ formatRupiah(order.change) }}</span>
            </div>
        </div>
        <div class="flex justify-end mt-6">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">
                Close
            </button>
        </div>
    </div>
</template>