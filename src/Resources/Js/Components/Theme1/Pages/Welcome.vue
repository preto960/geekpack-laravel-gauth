<template>
  <Head title="Home" />
  <div>
    <Toast />
    <!-- {{ $page }} --><!-- v-if="ComponentLoaded" -->
    <component  :is="LandingPage" :system="props"/>
    <!-- <div v-else class="flex flex-col items-center justify-center h-screen">
      <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-gray-900"></div>
      <div class="mt-4 text-lg text-gray-900 animate-pulse">loading...</div>
    </div> -->
  </div>
</template>

<script setup>
  import { defineProps } from 'vue';
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

/* const LandingPage = ref(null);
const ComponentLoaded = ref(false);

import(`../Components/${props.template}/LandingPage.vue`)
  .then(module => {
    LandingPage.value = markRaw(module.default);
    ComponentLoaded.value = true;
  })
  .catch(error => {
    console.error(`Error al cargar el componente LandingPage para el tema '${props.template}':`, error);
  }); */

</script>

  
<style>
  @import 'tailwindcss/tailwind.css';
</style>