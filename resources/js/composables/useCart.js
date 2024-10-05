import { ref, computed } from 'vue';

export default function useCart() {
    const items = ref([]);

    const addItem = (menu) => {
        const existingItem = items.value.find(item => item.id === menu.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            items.value.push({ ...menu, quantity: 1 });
        }
    };

    const removeItem = (itemId) => {
        console.log(itemId);
        items.value = items.value.filter(item => item.id !== itemId);
    };

    const updateQuantity = (itemId, newQuantity) => {
        const item = items.value.find(item => item.id === itemId);
        if (item) {
            item.quantity = Math.max(1, newQuantity);
        }
    };

    const subtotal = computed(() => {
        return items.value.reduce((total, item) => total + item.price * item.quantity, 0);
    });

    const tax = computed(() => subtotal.value * 0.1);
    const total = computed(() => subtotal.value + tax.value);

    return {
        items,
        addItem,
        removeItem,
        updateQuantity,
        subtotal,
        tax,
        total
    };
}
