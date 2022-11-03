<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';

export default {
    components: {
        AuthenticatedLayout, Head, Link, TextInput
    },
    props: {
        customers: Object
    },
    setup(){
        const destroy = (id) => {
            if (confirm('Hapus pelanggan ini?')){
                Inertia.delete(route('customers.destroy', id))
            }
        }

        return {
            destroy
        }
    },
    data(){
        return {
            search: ''
        }
    },
    computed: {
        filteredItems () {
            return this.customers.filter(item => {
                return item.name.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || item.email.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            })
        }
    }
}
</script>

<template>
    <Head title="Pelanggan"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Master data pelanggan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div v-if="$page.props.flash.message" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ $page.props.flash.message }}
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <div class="relative block">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </span>
                                <TextInput type="text" class="mt-1 pl-10 block w-full placeholder-gray-400 placeholder:text-xs" v-model="search" placeholder="Cari pelanggan..." />
                            </div>

                            <Link :href="route('customers.create')"
                                  class="px-4 py-2 bg-rose-500 text-white rounded-lg text-sm font-semibold leading-tight hover:bg-rose-600">
                                Buat pelanggan
                            </Link>
                        </div>

                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Username
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Phone number
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Address
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="customer in filteredItems" :key="customer.id" class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        <div class="">
                                            <div class="text-base font-semibold">{{ customer.name }}</div>
                                            <div class="font-normal text-gray-500">{{ customer.email }}</div>
                                        </div>
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ customer.phone_number ? customer.phone_number : 'belum didefinisikan' }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ customer.address ? customer.address : 'belum didefinisikan'}}
                                    </td>
                                    <td class="flex items-center py-4 px-6 space-x-3">
                                        <Link :href="route('customers.edit', customer.id)" class="font-medium text-blue-600 hover:underline">Edit</Link>
                                        <button @click="destroy(customer.id)" class="font-medium text-red-600 hover:underline">Remove</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
