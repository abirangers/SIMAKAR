<script setup>
import { onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import KasirLayout from "@/Layouts/KasirLayout.vue";
import MenuList from "@/Components/MenuList.vue";
import Cart from "@/Components/Cart.vue";
import CheckoutModal from "@/Components/CheckoutModal.vue";
import useCart from "@/composables/useCart";
import useCheckout from "@/composables/useCheckout";
import useFlashMessage from "@/composables/useFlashMessage";

const props = defineProps({
    categories: Array,
    menus: Array,
});

const { flashMessage, setFlashMessage } = useFlashMessage();
const {
    items: cartItems,
    addItem: addToCart,
    removeItem: removeFromCart,
    updateQuantity,
    subtotal,
    tax,
    total,
} = useCart();
const {
    showModal: showCheckoutModal,
    customerName,
    formattedCashInput,
    handleCheckout,
} = useCheckout(cartItems, subtotal, tax, total, setFlashMessage);

onMounted(() => {
    const page = usePage();
    if (page.props.flash.success) {
        setFlashMessage("success", page.props.flash.success);
    }
});
</script>

<template>
    <KasirLayout>
        <!-- Flash Message -->
        <div v-if="flashMessage" :class="[
            'm-4 p-4 rounded fixed top-0 left-0 right-0',
            flashMessage.type === 'success' ? 'bg-green-500' : 'bg-red-500',
        ]">
            {{ flashMessage.message }}
        </div>

        <div class="w-3/5">
            <div>
                <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-800">
                    Kasir
                </h2>
            </div>
            <div class="pb-4 border-b border-gray-200">
                <!-- Menu Category -->
                <ul class="flex flex-row p-0 mt-4 gap-x-2 menu">
                    <li>
                        <Link :class="{
                            active: !$page.props.ziggy.query.category,
                        }" :href="route('kasir.index')"
                            preserve-state
                            preserve-scroll>Semua</Link>
                    </li>
                    <li v-for="category in categories" :key="category.id">
                        <Link :class="{
                            active: $page.props.ziggy.query.category === category.name,
                        }" :href="route('kasir.index', { category: category.name })"
                            preserve-state
                            preserve-scroll>{{ category.name }}</Link>
                    </li>
                </ul>
            </div>
            <MenuList :menus="menus" @add-to-cart="addToCart" />
        </div>
        <div class="w-2/5 rounded-lg">
            <Cart 
                :cart-items="cartItems" 
                :subtotal="subtotal" 
                :tax="tax" 
                :total="total"
                @update-quantity="updateQuantity" 
                @remove-from-cart="removeFromCart"
                @checkout="showCheckoutModal = true" 
            />
        </div>

        <CheckoutModal v-model:show="showCheckoutModal" v-model:customer-name="customerName"
            v-model:formatted-cash-input="formattedCashInput" :total="total" @process="handleCheckout" />
    </KasirLayout>
</template>
