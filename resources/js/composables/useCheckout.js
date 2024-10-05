import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";

export default function useCheckout(
    cartItems,
    subtotal,
    tax,
    total,
    setFlashMessage
) {
    const showModal = ref(false);
    const customerName = ref("");
    const cashInput = ref(0);

    const formattedCashInput = computed({
        get: () =>
            cashInput.value
                ? cashInput.value
                      .toString()
                      .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                : "",
        set: (value) => {
            const numericValue = value.replace(/\D/g, "");
            cashInput.value = numericValue ? parseInt(numericValue, 10) : 0;
        },
    });

    const handleCheckout = () => {
        router.post(
            route("kasir.store"),
            {
                customer_name: customerName.value,
                subtotal: subtotal.value,
                tax: tax.value,
                total: total.value,
                cash: cashInput.value,
                cartItems: cartItems.value,
            },
            {
                onSuccess: () => {
                    setFlashMessage("success", "Order berhasil dibuat");
                    resetCheckout();
                },
                onError: (error) => {
                    const errorMessage = Object.values(error).flat().join(", ");
                    setFlashMessage("error", errorMessage);
                },
                onFinish: () => {
                    showModal.value = false;
                },
            }
        );
    };

    const resetCheckout = () => {
        customerName.value = "";
        cashInput.value = 0;
        showModal.value = false;
        cartItems.value = [];
    };

    return {
        showModal,
        customerName,
        formattedCashInput,
        handleCheckout,
    };
}
