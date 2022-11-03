<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import TextInput from '@/Components/TextInput.vue';

export default {
    created() {
        dayjs.extend(relativeTime);
        dayjs().locale('id');
    },
    components: {
        AuthenticatedLayout, Head, Link, TextInput
    },
    props: {
        complaints: Object,
        status: Array,
    },
    setup() {
        const destroy = (id) => {
            if (confirm('Hapus pengaduan ini')) {
                Inertia.delete(route('complaints.destroy', id))
            }
        }

        const updateStatus = (id, val) => {
            Inertia.put(route('complaints.updateStatus', id), {
                status: val
            });
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
            destroy, updateStatus, diffForHumans, formatDate
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
        }
    },
    computed: {
        filteredItems () {
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

                        <div class="flex justify-between items-center mb-6">
                            <div class="relative block">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-2 pt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 stroke-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </span>
                                <TextInput type="text" class="mt-1 pl-10 block w-full placeholder-gray-400 placeholder:text-xs" v-model="search" placeholder="Cari pengaduan..." />
                            </div>


                            <Link :href="route('complaints.create')" v-if="$page.props.auth.user.role === 'customer'"
                                  class="px-4 py-2 bg-rose-500 text-white rounded-lg text-sm font-semibold leading-tight hover:bg-rose-600">
                                Buat pengaduan
                            </Link>
                        </div>

                        <div v-if="Object.keys(filteredItems).length === 0" class="text-center text-sm text-gray-500">
                            Tidak ada pengaduan
                        </div>

                        <div v-else class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                                        {{ complaint.name }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ complaint.description }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="p-1 rounded uppercase leading-loose text-xs font-semibold"
                                              :class="{
                                            'bg-blue-100 text-blue-700' : complaint.status === 'process',
                                            'bg-gray-300 text-gray-700' : complaint.status === 'pending',
                                            'bg-green-100 text-green-700' : complaint.status === 'done'
                                        }">
                                            {{ complaint.status }}
                                        </span>
                                    </td>
                                    <td v-if="$page.props.auth.user.role === 'admin'" class="py-4 px-6">
                                        <div class="flex items-center space-x-4">
                                            <select v-model="complaint.status"
                                                    @change="updateStatus(complaint.id, complaint.status)"
                                                    class="rounded border-gray-300 focus:ring focus:ring-rose-300 focus:border-rose-300">
                                                <option v-for="s in status" :value="s">{{ s }}</option>
                                            </select>
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
                    <div
                        class="flex justify-end items-center p-6 space-x-2 rounded-b border-t border-gray-200">
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
