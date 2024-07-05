<template>
  <Head title="New Password" />
  <Toast />
  <div v-if="ComponentLoaded" class="flex flex-col items-center justify-center h-screen dark:bg-gray-800 dark:text-white">
    <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 dark:border-gray-300"></div>
    <div class="mt-4 text-lg dark:text-gray-300 animate-pulse">loading...</div>
  </div>
  <div v-else class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
      <div class="fixed top-4 right-0 bg-gray-200 dark:bg-gray-800 rounded-l-lg pl-3 pr-2 py-2 flex items-center justify-center">
      <ThemeToggleButton />
      </div>
      <div class="max-w-md w-full bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
          <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">New Password</h2>
          <form @submit.prevent="submit">
          <div class="mt-4">
              <label class="block text-gray-700 dark:text-gray-300">New Password</label>
              <div class="relative">
              <input v-model="form.password" :type="showPassword ? 'text' : 'password'" class="w-full mt-2 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300">
              <button type="button" @click="toggleShowPassword" class="absolute inset-y-0 right-0 px-3 pt-2 flex items-center">
                  <i class="pi" :class="showPassword ? 'pi-eye-slash' : 'pi-eye','dark:text-white'"></i>
              </button>
              </div>
              <InputError class="mt-2" :message="form.errors.password" />
          </div>
          <div class="mt-4">
              <label class="block text-gray-700 dark:text-gray-300">Confirm New Password</label>
              <div class="relative">
              <input v-model="form.password_confirmation" :type="showConfirmationPassword ? 'text' : 'password'" class="w-full mt-2 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300">
              <button type="button" @click="toggleShowConfirmationPassword" class="absolute inset-y-0 right-0 px-3 pt-2 flex items-center">
                  <i class="pi" :class="showConfirmationPassword ? 'pi-eye-slash' : 'pi-eye','dark:text-white'"></i>
              </button>
              </div>
              <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </div>
          <div class="mt-6">
              <button :disabled="form.isSubmitting" type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">
              <span v-if="form.isSubmitting">Reset...</span>
              <span v-else>Reset</span>
              </button>
          </div>
          </form>
      </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import InputError from '../../Component/InputError.vue';
import ThemeToggleButton from '../../Component/ThemeToggleButton.vue';  
import axios from 'axios';

const form = useForm({
  password: '',
  password_confirmation: '',
  isSubmitting: false,
  showPassword: false,
});

const showPassword = ref(false);
const showConfirmationPassword = ref(false);

const toast = useToast();

const ComponentLoaded = ref(false);

const submit = async () => {
  ComponentLoaded.value = true;
  form.clearErrors();
  form.isSubmitting = true;
  try {
      const url = window.location.href;
      const segments = url.split('/');
      const lastSegment = segments[segments.length - 1];

    const response = await axios.post(route('api.password-reset'), {
      token: lastSegment,
      password: form.password,
      password_confirmation: form.password_confirmation,
    }, {
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
    if (error.response && error.response.status === 422) {
      form.errors = error.response.data.errors;
    } else {
      form.clearErrors();
      toast.add({
        severity: 'error',
        summary: 'Registration Failed',
        detail: error.response.data.message || 'An error occurred.',
        life: 3000,
      });
    }
  } finally {
    form.isSubmitting = false;
  }
};

const toggleShowPassword = () => {
  showPassword.value = !showPassword.value;
};

const toggleShowConfirmationPassword = () => {
  showConfirmationPassword.value = !showConfirmationPassword.value;
};
</script>

<style scoped>
/* Estilos personalizados aquí */
</style>
