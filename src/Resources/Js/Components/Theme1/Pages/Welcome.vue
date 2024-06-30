<template>
  <Head title="Home" />
  <div>
    <Toast />
    <div v-if="ComponentLoaded" class="flex flex-col items-center justify-center h-screen">
      <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-gray-900"></div>
      <div class="mt-4 text-lg text-gray-900 animate-pulse">loading...</div>
    </div>
    <component v-else :is="LandingPage" :system="props"/>
  </div>
</template>

<script setup>
  import { defineProps, onMounted } from 'vue';
  import { Head } from '@inertiajs/vue3';
  import LandingPage from './LandingPage.vue';

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  canAuth: { type: Object },
  canSystemName: { type: String, required: true },
  laravelVersion: { type: String, required: true },
  phpVersion: { type: String, required: true },
  template: { type: String, required: true },
});

const ComponentLoaded = ref(true);

onMounted(() => {
  ComponentLoaded.value = false;
});

</script>

  
<style>
  @import 'tailwindcss/tailwind.css';
</style>