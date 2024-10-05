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
    categories: {
        type: Array,
        required: true,
    },
    menu: {
        type: Object,
        default: () => ({}),
    },
});

// Initialize form using Inertia's useForm
const form = useForm({
    name: '',
    price: '',
    stock: '',
    category_id: '',
    image: null,
});

// Reactive state variables
const imagePreview = ref(null);
const isEditing = ref(false);

// Computed property for formatted price
const formattedPrice = computed({
    get() {
        if (!form.price) return '';
        return form.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    set(value) {
        const numericValue = value.replace(/\D/g, '');
        form.price = numericValue;
    },
});

// Computed property for formatted stock
const formattedStock = computed({
    get() {
        if (!form.stock) return '';
        return form.stock.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    },
    set(value) {
        const numericValue = value.replace(/\D/g, '');
        form.stock = numericValue;
    },
});

// Initialize form data if editing an existing menu
onMounted(() => {
    if (props.menu && Object.keys(props.menu).length) {
        isEditing.value = true;
        form.name = props.menu.name || '';
        form.price = props.menu.price || '';
        form.stock = props.menu.stock || '';
        form.category_id = props.menu.category_id || '';
        imagePreview.value = props.menu.image ? `/storage/${props.menu.image}` : null;
    }
});

// Handle image file upload and preview
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    form.image = file || null;

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.value = null;
    }
};

// Submit form data to the server
const submitForm = () => {
    if (isEditing.value) {
        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('price', form.price);
        formData.append('stock', form.stock);
        formData.append('category_id', form.category_id);
        if (form.image) {
            formData.append('image', form.image);
        }
        formData.append('_method', 'PUT');

        router.post(route('menu.update', props.menu.id), formData, {
            forceFormData: true,
        });
    } else {
        form.post(route('menu.store'), {
            forceFormData: true,
        });
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-extrabold leading-tight tracking-tight text-gray-800">
                {{ isEditing ? 'Edit Menu' : 'Tambah Menu' }}
            </h2>
        </template>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-4 text-slate-900">
                <form @submit.prevent="submitForm" class="form-control">
                    <!-- Nama Menu Field -->
                    <div class="mb-4">
                        <InputLabel for="name" value="Nama Menu" />
                        <TextInput
                            id="name"
                            type="text"
                            class="w-full mt-1"
                            v-model="form.name"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <!-- Harga Field -->
                    <div class="mb-4">
                        <InputLabel for="price" value="Harga" />
                        <TextInput
                            id="price"
                            type="text"
                            class="w-full mt-1"
                            v-model="formattedPrice"
                            required
                        />
                        <InputError :message="form.errors.price" class="mt-2" />
                    </div>

                    <!-- Stok Field -->
                    <div class="mb-4">
                        <InputLabel for="stock" value="Stok" />
                        <TextInput
                            id="stock"
                            type="text"
                            class="w-full mt-1"
                            v-model="formattedStock"
                            required
                        />
                        <InputError :message="form.errors.stock" class="mt-2" />
                    </div>

                    <!-- Kategori Menu Field -->
                    <div class="mb-4">
                        <InputLabel for="category_id" value="Kategori Menu" />
                        <select
                            id="category_id"
                            v-model="form.category_id"
                            class="w-full mt-1 select select-bordered"
                            required
                        >
                            <option value="" disabled>Pilih kategori</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" class="mt-2" />
                    </div>

                    <!-- Gambar Field -->
                    <div class="mb-4">
                        <InputLabel for="image" value="Gambar" />
                        <FileInput
                            id="image"
                            type="file"
                            class="w-full mt-1"
                            @input="handleImageUpload"
                            :required="!isEditing"
                        />
                        <InputError :message="form.errors.image" class="mt-2" />
                        <div v-if="imagePreview" class="mt-2">
                            <img
                                :src="imagePreview"
                                alt="Preview"
                                class="rounded-lg shadow-md max-h-64"
                            />
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center mt-6">
                        <PrimaryButton class="mr-4">
                            {{ isEditing ? 'Update' : 'Simpan' }}
                        </PrimaryButton>
                        <Link :href="route('menu.index')" class="btn">
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