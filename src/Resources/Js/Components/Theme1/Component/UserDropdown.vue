<template>
    <div class="relative">
        <Link v-if="!isLoggedIn"
          :href="route('login')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Log in
      </Link>
      <Link v-if="!isLoggedIn"
          :href="route('register')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Register
      </Link>
      <div v-else class="relative">
        <button @click="toggleDropdown" class="flex items-center focus:outline-none">
          <img src="https://via.placeholder.com/150" alt="User Avatar" class="w-8 h-8 rounded-full">
          <span class="ml-2 dark:text-white">{{ user.name }}</span>
        </button>
        <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-lg">
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Profile</a>
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Settings</a>
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Logout</a>        
        </div>
      </div>
    </div>
</template>
  
<script setup>
    import { ref, defineProps } from 'vue';
    import { Link, router } from '@inertiajs/vue3';
    import { useStore } from 'vuex';

    const store = useStore();

    const dropdownOpen = ref(false);

    const user = (store.state.data !== null) ? store.state.data.user : null;

    function toggleDropdown() {
        dropdownOpen.value = !dropdownOpen.value;
    }

    const isLoggedIn = (store.state.data !== null) ? store.state.data.user : null;
</script>
  
<style scoped>
/* Agrega tus estilos aquí si es necesario */
</style>
  