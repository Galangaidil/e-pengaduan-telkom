<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['auth'])
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="max-w-screen-md mb-8 lg:mb-16">
                            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">
                                Selamat datang {{ props.auth.user.name }}
                            </h2>
                            <p class="text-gray-500 sm:text-xl dark:text-gray-400">
                                Ada masalah apa hari ini? Yuk adukan masalah kamu melalui link
                                <Link :href="route('complaints.create')" class="inline-flex space-x-1 font-medium text-rose-600 hover:underline">
                                    Buat pengaduan
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 001.06 0l7.22-7.22v5.69a.75.75 0 001.5 0v-7.5a.75.75 0 00-.75-.75h-7.5a.75.75 0 000 1.5h5.69l-7.22 7.22a.75.75 0 000 1.06z" clip-rule="evenodd" />
                                    </svg>
                                </Link>.
                                Atau kamu juga bisa memilih dari salah satu menu cepat di bawah ini.
                            </p>
                        </div>

                        <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                            <div>
                                <div
                                    class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-rose-100 lg:h-12 lg:w-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-rose-500 lg:w-6 lg:h-6">
                                        <path d="M2.22 2.22a.75.75 0 011.06 0l6.783 6.782a1 1 0 01.935.935l6.782 6.783a.75.75 0 11-1.06 1.06l-6.783-6.782a1 1 0 01-.935-.935L2.22 3.28a.75.75 0 010-1.06zM3.636 16.364a9.004 9.004 0 01-1.39-10.936L3.349 6.53a7.503 7.503 0 001.348 8.773.75.75 0 01-1.061 1.061zM6.464 13.536a5 5 0 01-1.213-5.103l1.262 1.262a3.493 3.493 0 001.012 2.78.75.75 0 01-1.06 1.06zM16.364 3.636a9.004 9.004 0 011.39 10.937l-1.103-1.104a7.503 7.503 0 00-1.348-8.772.75.75 0 111.061-1.061zM13.536 6.464a5 5 0 011.213 5.103l-1.262-1.262a3.493 3.493 0 00-1.012-2.78.75.75 0 011.06-1.06z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-bold">Lemot</h3>
                                <p class="text-gray-500 dark:text-gray-400">Pas di tes kecepatan internetnya cuma 20 Kbps, Ga bisa main sosmed 🥲.</p>
                            </div>
                            <div>
                                <div class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-rose-100 lg:h-12 lg:w-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-rose-500 lg:w-6 lg:h-6">
                                        <path fill-rule="evenodd" d="M2.22 2.22a.75.75 0 011.06 0l14.5 14.5a.75.75 0 11-1.06 1.06L2.22 3.28a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                        <path d="M4.73 7.912L2.191 10.75A.75.75 0 002.75 12h6.068L4.73 7.912zM9.233 12.415l-1.216 5.678a.75.75 0 001.292.657l2.956-3.303-3.032-3.032zM15.27 12.088l2.539-2.838A.75.75 0 0017.25 8h-6.068l4.088 4.088zM10.767 7.585l1.216-5.678a.75.75 0 00-1.292-.657L7.735 4.553l3.032 3.032z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-bold">Router Ga Hidup</h3>
                                <p class="text-gray-500 dark:text-gray-400">Udah di colokin, cuma ga ada tanda-tanda kehidupan 🥺.</p>
                            </div>
                            <div>
                                <div
                                    class="flex justify-center items-center mb-4 w-10 h-10 rounded-full bg-rose-100 lg:h-12 lg:w-12">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-rose-500 lg:w-6 lg:h-6">
                                        <path d="M8 16.25a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5a.75.75 0 01-.75-.75z" />
                                        <path fill-rule="evenodd" d="M4 4a3 3 0 013-3h6a3 3 0 013 3v12a3 3 0 01-3 3H7a3 3 0 01-3-3V4zm4-1.5v.75c0 .414.336.75.75.75h2.5a.75.75 0 00.75-.75V2.5h1A1.5 1.5 0 0114.5 4v12a1.5 1.5 0 01-1.5 1.5H7A1.5 1.5 0 015.5 16V4A1.5 1.5 0 017 2.5h1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-bold">Ga bisa konek</h3>
                                <p class="text-gray-500 dark:text-gray-400">Padahal passwordnya dah bener, tapi ga bisa nyambung ke wifi 🤯.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
