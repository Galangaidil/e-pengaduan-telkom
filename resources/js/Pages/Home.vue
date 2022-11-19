<script setup>
import { Link, Head } from '@inertiajs/inertia-vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Inertia } from "@inertiajs/inertia";
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

function redirectToLoginPage()
{
    return Inertia.get(route('login'));
}

function redirectToRegisterPage()
{
    return Inertia.get(route('register'));
}
</script>

<template>
    <Head title="Selamat datang di sistem pengaduan layanan telkom" />

    <div class="bg-white border-b border-rose-100 p-5">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <Link href="/">
                    <ApplicationLogo />
                </Link>

                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                    class="text-sm text-gray-700 hover:text-rose-600 hover:underline">
                Dashboard
                </Link>
                <PrimaryButton v-else @click="redirectToLoginPage">
                    Masuk
                </PrimaryButton>
            </div>
        </div>
    </div>

    <section class="bg-white pt-20">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                    Sistem Pengaduan Pelanggan Telkom
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
                    Apakah Anda mempunyai gangguan dan keluhan pada layanan kami? Jangan khawatir, lakukan pengaduan layanan! Tim kami siap membantu anda.
                </p>

                <Link @click="redirectToRegisterPage"
                    class="text-center bg-rose-500 px-8 py-3 rounded-lg text-white uppercase font-semibold">
                   Daftar
                </Link>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="https://img.freepik.com/free-vector/organic-flat-customer-support-illustration_23-2148899134.jpg?w=1800&t=st=1667467318~exp=1667467918~hmac=58db24b0bb6f8987019599c95886b48eca971c53555c7c1c2bb355b8a0ecb61c"
                    alt="mockup">
            </div>
        </div>
    </section>
</template>
