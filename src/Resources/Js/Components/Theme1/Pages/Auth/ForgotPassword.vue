<template>
  <Head title="Forgot Password" />
  <Toast />
  <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
      <div class="flex justify-end mb-4">
        <ThemeToggleButton />
      </div>
      <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">Forgot Password</h2>
      <form @submit.prevent="submit">
        <div class="mt-4">
          <label class="block text-gray-700 dark:text-gray-300">Email</label>
          <input v-model="form.email" type="email" class="w-full mt-2 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mt-6">
          <button :disabled="form.isSubmitting" type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">
            <span v-if="form.isSubmitting">Sending...</span>
            <span v-else>Send Reset Link</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import InputError from '../../Component/InputError.vue';
import ThemeToggleButton from '../../Component/ThemeToggleButton.vue';
import axios from 'axios';

const form = useForm({
  email: '',
  isSubmitting: false
});

const toast = useToast();

const submit = async () => {
  form.clearErrors();
  form.isSubmitting = true;

  try {
    const response = await axios.post(route('api.forgot-password'), {
      email: form.email
    }, {
      headers: {
        'Accept': 'application/json',
      }
    });

    toast.add({
      severity: 'success',
      summary: 'Forgot Password',
      detail: response.data.message,
      life: 5000
    });

    form.reset();
    form.isSubmitting = false;
  } catch (error) {
    form.isSubmitting = false;

    if (error.response && error.response.status === 422) {
      form.errors = error.response.data.errors;
    } else {
      form.clearErrors();
      toast.add({
        severity: 'error',
        summary: 'Forgot Password',
        detail: error.response.data.message || 'An error occurred.',
        life: 3000,
      });
    }
  } finally {
    form.isSubmitting = false;
  }
};
</script>

<style scoped>
/* Añadir estilos personalizados aquí si es necesario */
</style>
