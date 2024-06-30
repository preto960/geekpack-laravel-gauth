<template>
    <div class="relative">
      <button @click="toggleDropdown" class="flex items-center focus:outline-none">
        <template v-if="isLoggedIn">
          <img src="https://via.placeholder.com/150" alt="User Avatar" class="w-8 h-8 rounded-full">
          <span class="ml-2">{{ user.name }}</span>
        </template>
        <template v-else>
          <span class="text-gray-300 dark:text-gray-500">Login/Register</span>
        </template>
      </button>
      <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-lg">
        <template v-if="isLoggedIn">
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Profile</a>
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Settings</a>
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Logout</a>
        </template>
        <template v-else>
          <a :href="route('login')" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Login</a>
          <a :href="route('register')" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Register</a>
        </template>
      </div>
    </div>
</template>
  
<script setup>
    import { ref, defineProps } from 'vue';
    import { useStore } from 'vuex';

    const store = useStore();

    const dropdownOpen = ref(false);

    const user = (store.state.data !== null) ? store.state.data.user : null;

    function toggleDropdown() {
        dropdownOpen.value = !dropdownOpen.value;
    }

    const isLoggedIn = () => user !== null;
</script>
  
<style scoped>
/* Agrega tus estilos aquí si es necesario */
</style>
  