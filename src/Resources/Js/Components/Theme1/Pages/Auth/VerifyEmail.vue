<template>
  <Head title="Verify Email" />
  <Toast />
  <div v-if="ComponentLoaded" class="flex flex-col items-center justify-center h-screen dark:bg-gray-800 dark:text-white">
      <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 dark:border-gray-300"></div>
      <div class="mt-4 text-lg dark:text-gray-300 animate-pulse">loading...</div>
  </div>
  <div v-else class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="fixed top-4 right-0 bg-gray-200 dark:bg-gray-800 rounded-l-lg pl-3 pr-2 py-2 flex items-center justify-center">
      <ThemeToggleButton />
    </div>
    <div class="max-w-md w-full bg-white dark:bg-gray-800 dark:text-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-white">Verify Email</h2>
      <p class="text-center mt-4">
        To verify your email address click on the Verify button.
      </p>
      <form @submit.prevent="verificationLink" class="mt-6">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Verify</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted, ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import ThemeToggleButton from '../../Component/ThemeToggleButton.vue';
import axios from 'axios';  

const props = defineProps({
  verifyurl: String
})

const toast = useToast();
const ComponentLoaded = ref(false);

const verificationLink = async () => {
  ComponentLoaded.value = true;
  try {
    const response = await axios.get(props.verifyurl, {
      headers: {
        'Accept': 'application/json',
      }
    });

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: response.data.message,
      life: 2000,
    });
    
    setTimeout(() => {
      router.replace(route('login'));
    }, 3000);
  } catch (error) {
    ComponentLoaded.value = false;
    toast.add({
      severity: 'error',
      summary: 'Login Failed',
      detail: error.response.data.message || 'An error occurred.',
      life: 3000,
    });
  }
};
</script>

<style scoped>
/* Añadir estilos personalizados aquí */
</style>
