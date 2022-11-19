<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    components: {
    AuthenticatedLayout,
    Head,
    Link,
    TextInput,
    PrimaryButton
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
    },
    methods: {
        printAll(){
            window.print();
        },
        create(){
            return Inertia.get(route('customers.create'));
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

                        <div class="flex justify-between items-center mb-6 print:hidden">
                            <div class="relative block">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </span>
                                <TextInput type="text" class="mt-1 pl-10 block w-full placeholder-gray-400 placeholder:text-xs" v-model="search" placeholder="Cari pelanggan..." />
                            </div>

                            <div class="flex gap-2">
                                <PrimaryButton @click="create">
                                    Buat pelanggan
                                </PrimaryButton>

                                <button @click="printAll"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md text-base font-semibold flex space-x-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Print</span>
                                </button>
                            </div>
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
                                    <th scope="col" class="py-3 px-6" v-if="$page.props.auth.user.role === 'admin'">
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
                                    <td class="flex items-center py-4 px-6 space-x-3" v-if="$page.props.auth.user.role === 'admin'">
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
