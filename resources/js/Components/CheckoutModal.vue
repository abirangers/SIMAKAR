<script setup>
import { formatRupiah } from '@/utils/currency';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    show: Boolean,
    customerName: String,
    formattedCashInput: String,
    total: Number,
});

const emit = defineEmits(['update:show', 'update:customerName', 'update:formattedCashInput', 'process']);
</script>

<template>
    <Modal :show="show" @close="emit('update:show', false)">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Checkout
            </h2>

            <div class="mt-6">
                <TextInput
                    :modelValue="customerName"
                    @update:modelValue="emit('update:customerName', $event)"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Customer Name"
                />
            </div>

            <div class="mt-6">
                <TextInput
                    :modelValue="formattedCashInput"
                    @update:modelValue="emit('update:formattedCashInput', $event)"
                    type="text"
                    class="block w-full mt-1"
                    placeholder="Cash Amount"
                />
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-600">Total: {{ formatRupiah(total) }}</p>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" class="mr-3 btn btn-secondary" @click="emit('update:show', false)">
                    Cancel
                </button>
                <button type="button" class="btn btn-primary" @click="emit('process')">
                    Process Order
                </button>
            </div>
        </div>
    </Modal>
</template>
