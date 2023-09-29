<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, Link} from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    }
})

const form = useForm({});

const destroy = (product) => {
    if (confirm('Are you sure you want to delete it?')) {
        form.delete(route('products.destroy', [product]));
    }
};
</script>
<template>
    <Head title="Products"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
        </template>
        <template #content>
            <div class="mb-2">
                <Link :href="route('products.create')">
                    <PrimaryButton>Add Product</PrimaryButton>
                </Link
                >
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Edit
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Delete
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        v-for="product in products"
                        :key="product.id">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ product.id }}
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ product.name }}
                        </th>
                        <td class="px-6 py-4">
                            ${{ product.price }}
                        </td>
                        <td class="px-6 py-4">
                            <Link :href="route('products.edit',product.id)" class="px-4 py-2 text-white bg-blue-600 rounded-lg" >
                                Edit
                            </Link>
                        </td>
                        <td class="px-6 py-4">
                            <form @submit.prevent="destroy(product.id)">
                                <DangerButton>
                                    Delete
                                </DangerButton>
                            </form>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<style scoped>

</style>
