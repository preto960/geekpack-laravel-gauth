<template>
  <Head title="Register" />
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-center text-gray-700">Register</h2>
      <form >
        <div class="mt-4">
          <label class="block text-gray-700">Name</label>
          <input type="text" class="w-full mt-2 p-2 border rounded-lg">
        </div>
        <div class="mt-4">
          <label class="block text-gray-700">Email</label>
          <input type="email" class="w-full mt-2 p-2 border rounded-lg">
        </div>
        <div class="mt-4">
          <label class="block text-gray-700">Password</label>
          <input type="password" class="w-full mt-2 p-2 border rounded-lg">
        </div>
        <div class="mt-4">
          <label class="block text-gray-700">Confirm Password</label>
          <input type="password" class="w-full mt-2 p-2 border rounded-lg">
        </div>
        <div class="mt-6">
          <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Register</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
/* import { reactive } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const router = useRouter();

const register = async () => {
  try {
    await axios.post('/api/register', form);
    router.push({ name: 'dashboard' });
  } catch (error) {
    console.error(error);
  }
}; */
</script>

<style scoped>
/* Añadir estilos personalizados aquí */
</style>
