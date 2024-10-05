import { router } from '@inertiajs/vue3';

export function useOrders() {
    const deleteOrder = (id) => {
        router.delete(route('pendapatan.destroy', id, { absolute: true }));
    };

    const cetakOrder = (id) => {
        window.open(route('pendapatan.cetak', id), '_blank');
    };

    return {
        deleteOrder,
        cetakOrder,
    };
}
