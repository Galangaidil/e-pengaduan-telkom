<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import dayjs from "dayjs";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    complaint: Object,
    username: String
})

const formatDate = (date) => {
    if (!date) {
        return null;
    }

    return dayjs(date).format('DD/MMM/YYYY');
}

const destroy = (id) => {
    if (confirm('Hapus pengaduan ini?')) {
        Inertia.delete(route('complaints.destroy', id))
    }
}

const print = () => {
    confirm('print halaman ini');
}

</script>

<template>
    <Head title="Detail pengaduan"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail pengaduan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex lg:space-x-5 flex-col lg:flex-row">
                            <div class="w-full lg:w-2/3">
                                <article class="prose prose-img:rounded-xl">
                                    <h2 class="capitalize">{{complaint.title }}</h2>

                                    <small class="text-sm text-gray-500">
                                        Dibuat oleh {{ username }} {{ formatDate(complaint.created_at) }}, Terakhir di update: {{ formatDate(complaint.updated_at) }}.
                                    </small>

                                    <img :src="complaint.url" :alt="complaint.title">

                                    <p>
                                        {{ complaint.description }}
                                    </p>
                                </article>
                            </div>

                            <div class="w-full lg:w-1/3">
                                <h3 class="font-bold text-2xl text-gray-900 leading-loose flex space-x-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L12 12m6.894 5.785l-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864l-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                    </svg>
                                    <span>Pengaturan</span>
                                </h3>

                                <div class="mt-4 flex flex-col space-y-4">
                                    <button @click="print" class="bg-blue-600 text-white rounded py-2 font-semibold flex items-center justify-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                                            <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                                        </svg>
                                        <span>Download PDF</span>
                                    </button>

                                    <Link :href="route('complaints.edit', complaint.id)"
                                          class="bg-yellow-100 hover:bg-yellow-400 text-gray-700 hover:text-white rounded py-2 font-semibold flex items-center justify-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                                            <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                                        </svg>
                                        <span>Edit</span>
                                    </Link>

                                    <button @click="destroy(complaint.id)"
                                            class="bg-red-600 text-white rounded py-2 font-semibold flex items-center justify-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
