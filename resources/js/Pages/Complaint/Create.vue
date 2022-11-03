<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from "@/Components/TextareaInput.vue";
import FileInput from '@/Components/FileInput.vue';

export default {
    components: {
        AuthenticatedLayout, Head, Link,
        InputError, InputLabel, PrimaryButton, TextInput, TextareaInput, FileInput
    },
    props: {
      errors: Object
    },
    setup(){
        const form = useForm({
            user_id: usePage().props.value.auth.user.id,
            title: '',
            description: '',
            photo: null
        });

        return {
            form
        }
    },
    data(){
        return {
            photoContainer: null
        }
    },
    methods: {
        previewFile: function(event){
            this.form.photo = event[0];
            this.photoContainer = URL.createObjectURL(event[0]);
        }
    }
}
</script>

<template>
    <Head title="Pelanggan"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambahkan pengaduan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="max-w-md mx-auto">
                            <form @submit.prevent="form.post(route('complaints.store'))">
                                <div>
                                    <InputLabel for="title" value="Judul" />
                                    <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" />
                                    <InputError v-if="errors.title" :message="errors.title" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="description" value="Deskripsi" />
                                    <TextareaInput id="description" class="mt-1 block w-full" v-model="form.description" placeholder="Tuliskan masalah anda disini..." />
                                    <InputError v-if="errors.description" :message="errors.description" class="mt-2"/>
                                </div>

                                <div class="mt-4">
                                    <InputLabel for="photo" value="Lampirkan foto masalah" />
                                    <FileInput id="photo" @preview-file="previewFile" accept="image/*" />
                                    <InputError v-if="errors.photo" :message="errors.photo" class="mt-2"/>
                                </div>

                                <div class="mt-4">
                                    <img :src="photoContainer" class="rounded-lg">
                                </div>

                                <div class="flex justify-between mt-4">
                                    <Link :href="route('complaints.index')" class="text-sm text-gray-500">Batal</Link>

                                    <PrimaryButton :disabled="form.processing">
                                        Kirim
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


