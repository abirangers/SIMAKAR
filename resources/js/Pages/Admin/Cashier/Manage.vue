<script setup>
import FileInput from '@/Components/FileInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

// Define component props
const props = defineProps({
    cashier: {
        type: Object,
        default: () => ({}),
    },
});

// Initialize form using Inertia's useForm
const form = useForm({
    name: '',
    password: '',
    role: 'kasir',
});

// Reactive state variables
const isEditing = ref(false);
    
// Initialize form data if editing an existing cashier
onMounted(() => {
    if (props.cashier && Object.keys(props.cashier).length) {
        isEditing.value = true;
        form.name = props.cashier.name || '';
        form.password = props.cashier.password || '';
    }
});

// Submit form data to the server
const submitForm = () => {
    if (isEditing.value) {
        form.put(route('cashier.update', props.cashier.id));
    } else {
        form.post(route('cashier.store'), {
            forceFormData: true,
        });
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-800">
                {{ isEditing ? 'Edit Kasir' : 'Tambah Kasir' }}
            </h2>
        </template>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-4 text-slate-900">
                <form @submit.prevent="submitForm" class="form-control">
                    <!-- Nama Kasir Field -->
                    <div class="mb-4">
                        <InputLabel for="name" value="Nama Kasir" />
                        <TextInput
                            id="name"
                            type="text"
                            class="w-full mt-1"
                            v-model="form.name"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div class="mb-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="w-full mt-1"
                            v-model="form.password"
                        />
                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center mt-6">
                        <PrimaryButton class="mr-4">
                            {{ isEditing ? 'Update' : 'Simpan' }}
                        </PrimaryButton>
                        <Link :href="route('cashier.index')" class="btn">
                            <i class="pi pi-arrow-left"></i> Kembali
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Optional: Add any component-specific styles here */
</style>