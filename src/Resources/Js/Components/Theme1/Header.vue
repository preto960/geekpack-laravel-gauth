<template>
  <header class="flex justify-between items-center p-4 bg-white dark:bg-gray-800">
    <div class="text-xl font-bold">{{system.canSystemName}}</div>
    <div class="flex items-center space-x-4" v-if="system.canLogin">
      <Link v-if="!system.canAuth"
          :href="route('login')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Log in
      </Link>
      <Link v-if="!system.canAuth"
          :href="route('register')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Register
      </Link>
      <div v-else class="relative">
        <img src="https://via.placeholder.com/30" @click="toggleDropdown" class="w-6 h-6 rounded-full cursor-pointer" />
        <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 shadow-lg">
          <p class="px-4 text-sm text-gray-700 dark:text-gray-200">{{ system.canAuth.name }}</p>
          <hr class="border-gray-200 dark:border-gray-600">
          <Link
              :href="route('dashboard')"
              class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
          >
              Dashboard
          </Link>
          <Link
              @click="logout()"
              class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"    
          >
              Log Out
          </Link>
        </div>
      </div>
      <button @click="toggleTheme" class="text-gray-500">
        <svg v-if="theme === 'dark'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.66l-.7.7M4.34 19.66l-.7-.7M21 12h-1M4 12H3m16.66 4.34l-.7.7M6.34 4.34l-.7-.7M17 12a5 5 0 11-10 0 5 5 0 0110 0z"></path>
        </svg>
        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646a9 9 0 1011.708 11.708z"></path>
        </svg>
      </button>
    </div>
  </header>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
  isAuthenticated: Boolean,
  user: Object,
  theme: String,
  system: { type: Object }
});

const emit = defineEmits(['toggleAuth', 'toggleTheme']);

const dropdownOpen = ref(false);

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value;
};

const register = () => {
  emit('toggleAuth', true);
};

const logout = () => {
  emit('toggleAuth', false);
};

const toggleTheme = () => {
  if (props.theme === 'light') {
    emit('toggleTheme', 'dark');
    document.documentElement.classList.add('dark');
  } else {
    emit('toggleTheme', 'light');
    document.documentElement.classList.remove('dark');
  }
};
</script>

<style scoped>
/* Aquí puedes añadir estilos adicionales si es necesario */
</style>
