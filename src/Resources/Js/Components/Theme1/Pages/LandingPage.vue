<template>
  <div>
    <Header
      @toggleAuth="toggleAuth"
      :system="system"
    />
    <main class="flex flex-col items-center justify-center p-4 min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
      <h1 class="text-4xl font-bold mb-4">Bienvenido a {{ system.template }}</h1>
      <p class="mb-8 text-lg text-center">Tu solución moderna para X.</p>
      <button @click="getStarted" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Comenzar</button>
    </main>
  </div>
</template>

<script setup>
import { ref,defineProps } from 'vue';
import Header from '../Component/Header.vue';
import Button from 'primevue/button';
import { useToast } from 'primevue/usetoast';
const toast = useToast();
const props = defineProps({
  system: { type: Object }
});

const toggleAuth = (authState) => {
  isAuthenticated.value = authState;
};

</script>

<style scoped>
/* Aquí puedes añadir estilos adicionales si es necesario */
</style>
