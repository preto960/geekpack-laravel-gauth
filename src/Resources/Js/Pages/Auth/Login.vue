<template>
  <Head title="Login" />
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
          <input v-model="form.password" type="password" class="w-full mt-2 p-2 border rounded-lg">
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="block mt-4">
            <label class="flex items-center">
                <Checkbox v-model:checked="form.remember" name="remember" />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>
        </div>
        <div class="mt-6">
          <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Login</button>
        </div>
        <div class="mt-6">
          <Link :href="route('forgotpassword')"
              class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
              Forgot Password
          </Link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Theme1/Components/Checkbox.vue';
import InputError from '@/Components/Theme1/Components/InputError.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('api.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style scoped>
/* Añadir estilos personalizados aquí */
</style>
