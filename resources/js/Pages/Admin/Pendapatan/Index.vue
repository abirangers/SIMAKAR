<script setup>
import { ref, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { useOrders } from '@/composables/useOrders';
import useFlashMessage from "@/composables/useFlashMessage";
import OrderTable from '@/Components/OrderTable.vue';
import OrderDetails from '@/Components/OrderDetails.vue';

const props = defineProps({
    orders: {
        type: Array,
        default: () => [],
    },
});

const { deleteOrder, cetakOrder } = useOrders();
const { flashMessage, setFlashMessage } = useFlashMessage();

const showDetailModal = ref(false);
const selectedOrder = ref(null);

const detailOrder = (order) => {
    selectedOrder.value = order;
    showDetailModal.value = true;
};

onMounted(() => {
    const pageProps = usePage().props;
    if (pageProps.flash.success) {
        setFlashMessage(pageProps.flash.success);
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-800">
                Pendapatan
            </h2>
        </template>

        <div v-if="flashMessage" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ flashMessage }}
        </div>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-4 text-slate-900">
                <OrderTable 
                    :orders="orders"
                    @detail="detailOrder"
                    @delete="deleteOrder"
                    @print="cetakOrder"
                />
            </div>
        </div>

        <Modal :show="showDetailModal" @close="showDetailModal = false">
            <OrderDetails 
                v-if="selectedOrder"
                :order="selectedOrder"
                @close="showDetailModal = false"
            />
        </Modal>
    </AuthenticatedLayout>
</template>