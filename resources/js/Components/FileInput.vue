<template>
    <input @change="$emit('previewFile', $event.target.files)" type="file" class="block w-full mt-1 text-sm text-slate-500
      file:mr-4 file:py-2 file:px-4
      file:rounded-full file:border-0
      file:text-sm file:font-semibold
      file:bg-rose-50 file:text-rose-500
      hover:file:bg-rose-100
      focus:outline-none
    "/>
</template>
