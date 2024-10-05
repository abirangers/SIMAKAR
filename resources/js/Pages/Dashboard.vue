<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DashboardCard from '@/Components/DashboardCard.vue';

const props = defineProps({
    menuCount: Number,
    totalRevenue: Number,
    orderCount: Number,
    cashierCount: Number,
});

const dashboardItems = [
    {
        title: 'Menu',
        value: props.menuCount,
        icon: 'pi-book',
        color: 'blue'
    },
    {
        title: 'Pendapatan',
        value: props.totalRevenue,
        icon: 'pi-money-bill',
        color: 'green',
        formatValue: true
    },
    {
        title: 'Order',
        value: props.orderCount,
        icon: 'pi-shopping-cart',
        color: 'yellow'
    },
    {
        title: 'Kasir',
        value: props.cashierCount,
        icon: 'pi-user',
        color: 'purple'
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="grid grid-cols-4 gap-4">
            <DashboardCard
                v-for="(item, index) in dashboardItems"
                :key="index"
                :title="item.title"
                :value="item.value"
                :icon="item.icon"
                :color="item.color"
                :format-value="item.formatValue"
            />
        </div>
    </AuthenticatedLayout>
</template>
