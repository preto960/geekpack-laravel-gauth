<template>
  <Head title="Login" />
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
      <h2 class="text-2xl font-semibold text-center text-gray-700 dark:text-gray-200">Login</h2>
      <form @submit.prevent="submit">
        <div class="mt-4">
          <label class="block text-gray-700 dark:text-gray-300">Email</label>
          <input v-model="form.email" type="email" class="w-full mt-2 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mt-4">
          <label class="block text-gray-700 dark:text-gray-300">Password</label>
          <div class="relative">
            <input v-model="form.password" :type="showPassword ? 'text' : 'password'" class="w-full mt-2 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-300">
            <button type="button" @click="toggleShowPassword" class="absolute inset-y-0 right-0 px-3 pt-2 flex items-center">
              <i class="pi" :class="showPassword ? 'pi-eye-slash' : 'pi-eye','dark:text-white'"></i>
            </button>
          </div>
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="flex items-center justify-between mt-4">
          <div class="flex items-center">
            <!-- <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span> -->
          </div>
          <div>
            <Link :href="route('forgotpassword')" class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
              Forgot Password?
            </Link>
          </div>
        </div>
        <div class="mt-6">
          <button :disabled="form.isSubmitting" type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">
            <span v-if="form.isSubmitting">Signing In...</span>
            <span v-else>Sign In</span>
          </button>
        </div>
        <div class="mt-6 dark:text-gray-400">New on our platform? 
          <Link :href="route('register')" class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
            Create an account
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Checkbox from '../../Component/Checkbox.vue';
import InputError from '../../Component/InputError.vue';
import ThemeToggleButton from '../../Component/ThemeToggleButton.vue';
import { ref } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';

const form = useForm({
  email: 'preto@example.com',
  password: 'password',
  remember: false,
  isSubmitting: false
});

const ComponentLoaded = ref(false);

const store = useStore();

const showPassword = ref(false);

const toast = useToast();

const submit = async () => {
  ComponentLoaded.value = true;
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
      detail: 'Successful Login',
      life: 2000,
    });
    form.reset();
    
    setTimeout(() => {
      const userLogin = response.data;
      store.commit('setUser', userLogin);
      router.replace('/dashboard');
    }, 3000);
  } catch (error) {
    ComponentLoaded.value = false;
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
