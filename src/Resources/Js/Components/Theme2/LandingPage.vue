<template>
    <div :class="theme">
      <Header
        :isAuthenticated="isAuthenticated"
        :user="user"
        :theme="theme"
        @toggleAuth="toggleAuth"
        @toggleTheme="toggleTheme"
      />
      <main class="flex flex-col items-center justify-center p-4 min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <h1 class="text-4xl font-bold mb-4">Bienvenido a MyApp</h1>
        <p class="mb-8 text-lg text-center">Tu solución moderna para X.</p>
        <button @click="getStarted" class="px-6 py-2 bg-blue-500 text-white rounded-lg">Comenzar</button>
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import Header from '../Components/Header.vue';
  
  const isAuthenticated = ref(false);
  const user = ref({
    name: "John Doe",
    avatar: "https://via.placeholder.com/40",
  });
  const theme = ref('light');
  
  const toggleAuth = (authState) => {
    isAuthenticated.value = authState;
  };
  
  const toggleTheme = (newTheme) => {
    theme.value = newTheme;
  };
  
  const getStarted = () => {
    // Lógica para comenzar
  };
  </script>
  
  <style scoped>
  /* Aquí puedes añadir estilos adicionales si es necesario */
  </style>
  