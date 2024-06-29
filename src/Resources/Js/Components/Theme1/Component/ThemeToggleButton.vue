<template>
  <button @click="toggleTheme" class="text-gray-500">
    <svg v-if="theme === 'dark'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.66-12.66l-.7.7M4.34 19.66l-.7-.7M21 12h-1M4 12H3m16.66 4.34l-.7.7M6.34 4.34l-.7-.7M17 12a5 5 0 11-10 0 5 5 0 0110 0z"></path>
    </svg>
    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646a9 9 0 1011.708 11.708z"></path>
    </svg>
  </button>
</template>

<script setup>
import { computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const theme = computed(() => store.state.theme);

const toggleTheme = () => {
  const newTheme = theme.value === 'dark' ? 'light' : 'dark';
  store.commit('setThemeToggle', newTheme);
};
</script>

<style scoped>
/* Aquí puedes agregar estilos específicos para el botón si lo deseas */
</style>
