<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-rose-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-600 active:bg-rose-700 focus:outline-none focus:border-rose-600 focus:shadow-outline-gray transition ease-in-out duration-150">
        <slot />
    </button>
</template>
