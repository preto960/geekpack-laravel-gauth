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
      <ThemeToggleButton :theme="theme" @toggle-theme="toggleTheme" />
    </div>
  </header>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ThemeToggleButton from 'Components/ThemeToggleButton.vue';

const props = defineProps({
  isAuthenticated: Boolean,
  user: Object,
  theme: String,
  system: { type: Object }
});

const emit = defineEmits(['toggleAuth', 'toggleTheme']);

const dropdownOpen = ref(false);

const theme = ref('light');

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
  theme.value = theme.value === 'dark' ? 'light' : 'dark';
};
</script>

<style scoped>
/* Aquí puedes añadir estilos adicionales si es necesario */
</style>
