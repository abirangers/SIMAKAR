<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    cashiers: Array,
    default: () => [],
});

const editCashier = (id) => {
    router.get(route('cashier.edit', id));
}

const flashMessage = ref(null);

const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

const deleteCashier = (id) => {
    router.delete(route('cashier.destroy', id, { absolute: true }), {
        onSuccess: () => {
            flashMessage.value = usePage().props.flash.success;
            setTimeout(() => {
                flashMessage.value = null;
            }, 3000);
        }
    });
}

onMounted(() => {
    const pageProps = usePage().props;
    if (pageProps.flash.success) {
        flashMessage.value = pageProps.flash.success;
        setTimeout(() => {
            flashMessage.value = null;
        }, 3000);
    }
});

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-800">
                Kasir
            </h2>
            <Link :href="route('cashier.create')" class="text-white bg-blue-600 btn hover:bg-blue-700">
                <i class="text-sm pi pi-plus"></i>
                Tambah Kasir
            </Link>
        </template>

        <div v-if="flashMessage" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ flashMessage }}
        </div>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-4 text-slate-900">
                <table class="table table-lg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cashier in cashiers" v-if="cashiers.length > 0">
                            <td>{{ cashiers.indexOf(cashier) + 1 }}</td>
                            <td>{{ cashier.name }}</td>
                            <td class="flex items-center gap-2">
                                <button class="btn btn-sm btn-warning" @click="editCashier(cashier.id)">
                                    <i class="text-sm pi pi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-error" @click="deleteCashier(cashier.id)">
                                    <i class="text-sm pi pi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="3" class="text-center">Tidak ada data kasir tersedia.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>