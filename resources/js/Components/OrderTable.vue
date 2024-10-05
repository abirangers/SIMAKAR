<script setup>
import { formatRupiah } from '@/utils/currency';

defineProps({
    orders: {
        type: Array,
        required: true,
    },
});

defineEmits(['detail', 'delete', 'print']);
</script>

<template>
    <table class="table table-lg">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pesanan</th>
                <th>Nama Kasir</th>
                <th>Nama Pelanggan</th>
                <th>Item</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(order, index) in orders" :key="order.id">
                <td>{{ index + 1 }}</td>
                <td>{{ order.order_code }}</td>
                <td>{{ order.user.name }}</td>
                <td>{{ order.customer_name }}</td>
                <td>{{ order.order_items.length }}</td>
                <td>{{ formatRupiah(order.total) }}</td>
                <td class="flex items-center gap-2">
                    <button
                        class="btn btn-sm btn-info"
                        @click="$emit('detail', order)"
                        aria-label="View Order Details"
                    >
                        <i class="text-sm pi pi-eye"></i>
                    </button>
                    <button
                        class="btn btn-sm btn-success"
                        @click="$emit('print', order.id)"
                        aria-label="Print Order"
                    >
                        <i class="text-sm pi pi-print"></i>
                    </button>
                    <button
                        class="btn btn-sm btn-error"
                        @click="$emit('delete', order.id)"
                        aria-label="Delete Order"
                    >
                        <i class="text-sm pi pi-trash"></i>
                    </button>
                </td>
            </tr>
            <tr v-if="orders.length === 0">
                <td colspan="7" class="text-center">Tidak ada data pendapatan tersedia.</td>
            </tr>
        </tbody>
    </table>
</template>