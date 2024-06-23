<template>
  <Head title="Login" />
  <Toast />
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-center text-gray-700">Login</h2>
      <form @submit.prevent="submit">
        <div class="mt-4">
          <label class="block text-gray-700">Email</label>
          <input v-model="form.email" type="email" class="w-full mt-2 p-2 border rounded-lg">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mt-4">
          <label class="block text-gray-700">Password</label>
          <div class="relative">
            <input v-model="form.password" :type="showPassword ? 'text' : 'password'" class="w-full mt-2 p-2 border rounded-lg">
            <button type="button" @click="toggleShowPassword" class="absolute inset-y-0 right-0 px-3 pt-2 flex items-center">
              <i class="pi" :class="showPassword ? 'pi-eye-slash' : 'pi-eye'"></i>
            </button>
          </div>
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="block mt-4">
          <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
          </label>
        </div>
        <div class="mt-6">
          <button :disabled="form.isSubmitting" type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">
            <span v-if="form.isSubmitting">Logging in...</span>
            <span v-else>Login</span>
          </button>
        </div>
        <div class="mt-6">
          <Link :href="route('forgotpassword')"
            class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
            Forgot Password
          </Link>
        </div>
        <div class="mt-6">New on our platform? 
          <Link :href="route('register')"
            class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
          Create an account
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';
import Checkbox from '@/Components/Theme1/Components/Checkbox.vue';
import InputError from '@/Components/Theme1/Components/InputError.vue';
import { ref } from 'vue';
import axios from 'axios';

const form = useForm({
  email: '',
  password: '',
  remember: false,
  isSubmitting: false
});

const showPassword = ref(false);

const toast = useToast();

const submit = async () => {
  form.clearErrors();
  form.isSubmitting = true;
  try {
    const response = await axios.post(route('api.login'), {
      email: form.email,
      password: form.password,
      remember: form.remember ? 'on' : '',
    }, {
      headers: {
        'Accept': 'application/json',
      }
    });

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: response.data.message,
      life: 5000,
    });
    form.reset();
  } catch (error) {
    if (error.response && error.response.status === 422) {
      form.errors = error.response.data.errors;
    } else {
      form.clearErrors();
      toast.add({
        severity: 'error',
        summary: 'Login Failed',
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
</script>

<style scoped>
/* Añadir estilos personalizados aquí */
</style>
