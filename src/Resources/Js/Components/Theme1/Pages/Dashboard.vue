<template>
  <Head title="Dashboard" />
  <Toast />
  <div v-if="ComponentLoaded" class="flex flex-col items-center justify-center h-screen dark:bg-gray-800 dark:text-white">
      <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 dark:border-gray-300"></div>
      <div class="mt-4 text-lg dark:text-gray-300 animate-pulse">loading...</div>
    </div>
  <div v-else class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
    <Sidebar :isMinimized="isMinimized" />

    <div class="flex-1">
      <header class="bg-white dark:bg-gray-800 shadow">
        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
          <div class="flex items-center space-x-4">
            <button @click="toggleSidebar" class="text-gray-400 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-200 focus:outline-none focus:text-gray-900 dark:focus:text-gray-200">
              <svg v-if="isMinimized" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
              </svg>
              <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-200">Dashboard</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span>{{ currentTime }}</span>
            <ThemeToggleButton />
            <UserDropdown @ComponentLoaded="handleComponentLoaded"/>
          </div>
        </div>
      </header>

      <main>
        <div class="mx-auto py-6 sm:px-6 lg:px-8">
          <div class="px-4 py-6 sm:px-0">
            <div class="border-4 border-dashed border-gray-200 dark:border-gray-700 rounded-lg h-96"></div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import ThemeToggleButton from '../Component/ThemeToggleButton.vue';
import UserDropdown from '../Component/UserDropdown.vue';
import Sidebar from '../Component/Sidebar.vue';

const toast = useToast();
const isMinimized = ref(false);
const ComponentLoaded = ref(true);

const currentTime = ref('')

const toggleSidebar = () => {
  isMinimized.value = !isMinimized.value;
}

onMounted(() => {
  ComponentLoaded.value = false;
  updateCurrentTime()
  setInterval(updateCurrentTime, 1000)
});

function updateCurrentTime() {
  const now = new Date()
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  const seconds = String(now.getSeconds()).padStart(2, '0')
  currentTime.value = `${hours}:${minutes}:${seconds}`
}

const handleComponentLoaded = (value) => {
  ComponentLoaded.value = value;
};

</script>

<style scoped>
/* Estilos adicionales según sea necesario */
</style>
