<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/inertia-vue3';
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    user: Object
})

const form = useForm({
    address: props.user.address,
    phone_number: props.user.phone_number
})

</script>

<template>

    <Head title="My Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Profile
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

                        <div class="flex lg:space-x-5 space-x-0 flex-col space-y-5 lg:space-y-0 lg:flex-row">

                            <div class="relative w-full lg:w-1/3 border-2 border-blue-300 rounded bg-blue-50">
                                <div
                                    class="absolute top-0 right-0 mr-2 mt-2 text-xs bg-blue-500 text-white rounded px-1 uppercase font-semibold leading-loose">
                                    {{ user?.role }}
                                </div>
                                <div class="flex justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="w-20 h-20 stroke-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="my-3 text-center ">
                                    <h3 class="text-lg text-gray-800 font-semibold leading-loose">{{ user?.name }}</h3>
                                    <p class="block text-sm text-gray-700">
                                        {{ user?.email }} {{ user?.phone_number }}
                                    </p>
                                    <span class="text-gray-500 text-xs">
                                        {{ user?.address }}
                                    </span>
                                </div>
                            </div>

                            <div class="w-full lg:w-2/3 border rounded p-8">
                                <form @submit.prevent="form.put(route('updateProfile'))">
                                    <div>
                                        <InputLabel for="address" value="Alamat"/>
                                        <TextInput id="address" class="mt-1 block w-full" type="text"
                                                   v-model="form.address"/>
                                        <InputError :message="form.errors.address"/>
                                    </div>

                                    <div class="mt-4">
                                        <InputLabel for="phone_number" value="Nomor HP"/>
                                        <TextInput id="phone_number" class="mt-1 block w-full" type="text"
                                                   v-model="form.phone_number"/>
                                        <InputError :message="form.errors.phone_number"/>
                                    </div>

                                    <div class="mt-4 flex justify-end">
                                        <primary-button>
                                            Simpan
                                        </primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
