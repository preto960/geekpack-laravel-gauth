<template>
  <Head title="Register" />
  <Toast />
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-center text-gray-700">Register</h2>
      <form @submit.prevent="submit">
        <div class="mt-4">
          <label class="block text-gray-700">Name</label>
          <input v-model="form.name" type="text" class="w-full mt-2 p-2 border rounded-lg">
          <InputError class="mt-2" :message="form.errors.name" />
        </div>
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
        <div class="mt-4">
          <label class="block text-gray-700">Confirm Password</label>
          <div class="relative">
            <input v-model="form.password_confirmation" :type="showConfirmationPassword ? 'text' : 'password'" class="w-full mt-2 p-2 border rounded-lg">
            <button type="button" @click="toggleShowConfirmationPassword" class="absolute inset-y-0 right-0 px-3 pt-2 flex items-center">
              <i class="pi" :class="showConfirmationPassword ? 'pi-eye-slash' : 'pi-eye'"></i>
            </button>
          </div>
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
        <div class="mt-6">
          <button :disabled="form.isSubmitting" type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">
            <span v-if="form.isSubmitting">Signing Up...</span>
            <span v-else>Sign Up</span>
          </button>
        </div>
        <div class="mt-6">Already have an account? 
          <Link :href="route('login')"
            class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
          Sign in instead
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
import InputError from '../Components/InputError.vue';
import { ref } from 'vue';
import axios from 'axios';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  isSubmitting: false,
  showPassword: false,
});

const showPassword = ref(false);
const showConfirmationPassword = ref(false);

const toast = useToast();

const submit = async () => {
  form.clearErrors();
  form.isSubmitting = true;
  try {
    const response = await axios.post(route('api.register'), {
      name: form.name,
      email: form.email,
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
const toggleShowConfirmationPassword = () => {
  showConfirmationPassword.value = !showConfirmationPassword.value;
};
</script>

<style scoped>
/* Estilos personalizados aquí */
</style>
