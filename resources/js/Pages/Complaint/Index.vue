<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

export default {
    created() {
        dayjs.extend(relativeTime);
        dayjs().locale('id');
    },
    components: {
        AuthenticatedLayout, Head, Link, TextInput, PrimaryButton
    },
    props: {
        complaints: Object,
    },
    setup() {
        const destroy = (id) => {
            if (confirm('Hapus pengaduan ini')) {
                Inertia.delete(route('complaints.destroy', id))
            }
        }

        const diffForHumans = (date) => {
            if (!date) {
                return null;
            }

            return dayjs(date).fromNow();
        }

        const formatDate = (date) => {
            if (!date) {
                return null;
            }

            return dayjs(date).format('DD/MMM/YYYY');
        }

        return {
            destroy, diffForHumans, formatDate
        }
    },
    data() {
        return {
            modal: false,
            urlPhoto: '',
            search: ''
        }
    },
    methods: {
        toggleModal(url) {
            this.modal = !this.modal;
            this.urlPhoto = url;
        },
        printAll() {
            window.print();
        },
        create() {
            return Inertia.get(route('complaints.create'));
        }
    },
    computed: {
        filteredItems() {
            return this.complaints.filter(item => {
                return item.title.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || item.status.toLowerCase().indexOf(this.search.toLowerCase()) > -1
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
                Pengaduan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div v-if="$page.props.flash.message"
                             class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                            {{ $page.props.flash.message }}
                        </div>

                        <div class="flex justify-between items-center mb-6 print:hidden">
                            <div class="relative block">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                    </svg>
                                </span>
                                <TextInput type="text"
                                           class="mt-1 pl-10 block w-full placeholder-gray-400 placeholder:text-xs"
                                           v-model="search" placeholder="Cari pengaduan..."/>
                            </div>


                            <div class="flex gap-2">
                                <PrimaryButton @click="create" v-if="$page.props.auth.user.role === 'customer'">
                                    Buat pengaduan
                                </PrimaryButton>
                                <button @click="printAll"
                                        v-if="$page.props.auth.user.role === 'admin' || $page.props.auth.user.role === 'manager'"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-base font-semibold flex space-x-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                              d="M5 2.75C5 1.784 5.784 1 6.75 1h6.5c.966 0 1.75.784 1.75 1.75v3.552c.377.046.752.097 1.126.153A2.212 2.212 0 0118 8.653v4.097A2.25 2.25 0 0115.75 15h-.241l.305 1.984A1.75 1.75 0 0114.084 19H5.915a1.75 1.75 0 01-1.73-2.016L4.492 15H4.25A2.25 2.25 0 012 12.75V8.653c0-1.082.775-2.034 1.874-2.198.374-.056.75-.107 1.127-.153L5 6.25v-3.5zm8.5 3.397a41.533 41.533 0 00-7 0V2.75a.25.25 0 01.25-.25h6.5a.25.25 0 01.25.25v3.397zM6.608 12.5a.25.25 0 00-.247.212l-.693 4.5a.25.25 0 00.247.288h8.17a.25.25 0 00.246-.288l-.692-4.5a.25.25 0 00-.247-.212H6.608z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    <span>Print</span>
                                </button>
                            </div>
                        </div>

                        <div v-if="Object.keys(filteredItems).length === 0" class="text-center text-sm text-gray-500">
                            Tidak ada pengaduan
                        </div>

                        <div v-else class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-rose-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Judul
                                    </th>
                                    <th scope="col" class="py-3 px-6" v-if="$page.props.auth.user.role === 'admin'">
                                        Pelanggan
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Deskripsi
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Keterangan
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Status
                                    </th>
                                    <th scope="col" class="py-3 px-6" v-if="$page.props.auth.user.role === 'admin'">
                                        Aksi
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="complaint in filteredItems" :key="complaint.id"
                                    class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="py-4 px-6 text-gray-900 whitespace-normal">
                                        <div class="flex items-center">
                                            <img class="w-10 h-10 rounded-lg cursor-pointer" :src="complaint.url"
                                                 @click="toggleModal(complaint.url)">
                                            <div class="pl-3">
                                                <div class="text-base font-semibold">
                                                    {{ complaint.title }}
                                                </div>
                                                <div class="font-normal text-xs text-gray-400">
                                                    {{ formatDate(complaint.created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="py-4 px-6" v-if="$page.props.auth.user.role === 'admin'">
                                        <Link :href="route('customers.show', complaint.user_id)" class="hover:text-rose-500">
                                            {{ complaint.name }}
                                        </Link>
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ complaint.description }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ complaint.keterangan }}
                                    </td>
                                    <td class="py-4 px-6">
                                            <span class="p-1 rounded uppercase leading-loose text-xs font-semibold"
                                                  :class="{
                                                    'bg-blue-100 text-blue-700': complaint.status === 'process',
                                                    'bg-gray-300 text-gray-700': complaint.status === 'pending',
                                                    'bg-green-100 text-green-700': complaint.status === 'done'
                                                }">
                                                {{ complaint.status }}
                                            </span>
                                    </td>
                                    <td v-if="$page.props.auth.user.role === 'admin'" class="py-4 px-6">
                                        <div class="flex items-center space-x-4">
                                            <Link :href="route('complaints.show', complaint.id)"
                                                  class="rounded p-1 hover:bg-rose-50 hover:text-rose-600 focus:outline-none focus:bg-rose-50 focus:border-rose-300 focus:text-rose-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                                                </svg>
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Main modal -->
        <div v-if="modal" id="defaultModal" tabindex="-1" aria-hidden="true"
             class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 w-full md:inset-0 md:h-full justify-center items-center bg-gray-50/50 backdrop-blur">
            <div class="relative p-4 m-auto w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex justify-between items-start p-4 rounded-t border-b">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Foto Pengaduan
                        </h3>
                        <button type="button" @click="toggleModal"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                data-modal-toggle="defaultModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <img :src="urlPhoto" alt="" class="rounded-lg">
                    </div>
                    <!-- Modal footer -->
                    <div class="flex justify-end items-center p-6 space-x-2 rounded-b border-t border-gray-200">
                        <button @click="toggleModal" type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
