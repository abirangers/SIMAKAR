<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    menus: Array,
    default: () => [],
});

const editMenu = (id) => {
    router.get(route('menu.edit', id));
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

const deleteMenu = (id) => {
    router.delete(route('menu.destroy', id, { absolute: true }), {
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
                Menu
            </h2>
            <Link :href="route('menu.create')" class="text-white bg-blue-600 btn hover:bg-blue-700">
                <i class="text-sm pi pi-plus"></i>
                Tambah Menu
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
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori Menu</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="menu in menus" v-if="menus.length > 0">
                            <th><img :src="`/storage/${menu.image}`" alt="" class="object-cover w-10 h-10"></th>
                            <td>{{ menu.name }}</td>
                            <td>{{ menu.category.name }}</td>
                            <td>{{ formatRupiah(menu.price) }}</td>
                            <td>{{ menu.stock }}</td>
                            <td class="flex items-center gap-2">
                                <button class="btn btn-sm btn-warning" @click="editMenu(menu.id)">
                                    <i class="text-sm pi pi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-error" @click="deleteMenu(menu.id)">
                                    <i class="text-sm pi pi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="5" class="text-center">Tidak ada data menu tersedia.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>