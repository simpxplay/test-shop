<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, Link} from '@inertiajs/vue3';
import {onMounted} from "vue";


const props = defineProps({
    product: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.product.id,
    name: props.product.name,
    price: props.product.price,
    file: props.product.file
});

const update = () => {
    form.put(route("products.update", props.product.id));
};

</script>
<template>
    <Head title="Products"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
        </template>
        <template #content>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form @submit.prevent="update">
                        <div class="mb-6">
                            <label
                                for="Name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Name</label
                            >
                            <input
                                type="text"
                                v-model="form.name"
                                name="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder=""
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>
                        <div class="mb-6">
                            <label
                                for="Price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Price</label
                            >
                            <input
                                type="text"
                                v-model="form.price"
                                name="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder=""
                            />
                            <div
                                v-if="form.errors.price"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.price }}
                            </div>
                        </div>
                        <div class="mb-6">
                            <label
                                for="File"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >Price</label
                            >
                            <input
                                type="file"
                                @input="form.file = $event.target.files[0]"
                                name="file"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder=""
                            />
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                            <div
                                v-if="form.errors.file"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.file }}
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white bg-blue-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 "
                            :disabled="form.processing"
                            :class="{ 'opacity-25': form.processing }"
                        >
                            Update
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
