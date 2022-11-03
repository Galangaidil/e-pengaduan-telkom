<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from "@/Components/TextareaInput.vue";

export default {
    components: {
        AuthenticatedLayout, Head, Link,
        InputLabel, InputError, PrimaryButton, TextInput, TextareaInput
    },
    setup() {
        const form = useForm({
            name: '',
            email: '',
            password: '',
            phone_number: '',
            address: '',
        })

        return {form};
    },
    props: {
        errors: Object
    }
}
</script>

<template>
    <Head title="Pelanggan"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah data pelanggan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="max-w-md mx-auto">
                            <form @submit.prevent="form.post(route('customers.store'))">

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Informasi pribadi pelanggan</h3>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="name" value="Nama pelanggan"/>
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"/>
                                    <InputError v-if="errors.name" class="mt-2" :message="errors.name"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="phone_number" value="Nomor telepon"/>
                                    <TextInput id="phone_number" type="number" class="mt-1 block w-full" v-model="form.phone_number"/>
                                    <InputError v-if="errors.phone_number" class="mt-2" :message="errors.phone_number"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="address" value="Alamat"/>
                                    <TextareaInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" placeholder="Tuliskan alamat pelanggan"/>
                                    <InputError v-if="errors.address" class="mt-2" :message="errors.address"/>
                                </div>

                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold text-gray-800">Informasi login pelanggan</h3>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="email" value="Email"/>
                                    <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"/>
                                    <InputError v-if="errors.email" class="mt-2" :message="errors.email"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="password" value="Password"/>
                                    <TextInput id="password" type="password" class="mt-1 block w-full"
                                               v-model="form.password"/>
                                    <InputError v-if="errors.password" class="mt-2" :message="errors.password"/>
                                </div>

                                <div class="flex justify-between items-baseline mt-4">
                                    <Link :href="route('customers.index')" class="text-sm text-gray-700 hover:underline">Batal</Link>

                                    <PrimaryButton :disabled="form.processing">
                                        Simpan
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
