<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Login</h2>
        <form @submit.prevent="login">
          <div class="mt-4">
            <label class="block text-gray-700">Email</label>
            <input v-model="form.email" type="email" class="w-full mt-2 p-2 border rounded-lg">
          </div>
          <div class="mt-4">
            <label class="block text-gray-700">Password</label>
            <input v-model="form.password" type="password" class="w-full mt-2 p-2 border rounded-lg">
          </div>
          <div class="mt-6">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Login</button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { reactive } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const form = reactive({
    email: '',
    password: ''
  });
  
  const router = useRouter();
  
  const login = async () => {
    try {
      await axios.post('/api/login', form);
      router.push({ name: 'dashboard' });
    } catch (error) {
      console.error(error);
    }
  };
  </script>
  
  <style scoped>
  /* Añadir estilos personalizados aquí */
  </style>
  