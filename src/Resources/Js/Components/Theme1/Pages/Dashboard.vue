<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <div class="flex items-center space-x-4">
          <ThemeToggleButton />
          <div class="relative">
            <button @click="toggleDropdown" class="flex items-center space-x-2 focus:outline-none">
              <img :src="user.image" alt="User Image" class="w-8 h-8 rounded-full">
              <span class="font-medium text-gray-700">{{ store.data.user.name }}</span>
              <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div v-if="isDropdownOpen" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- Main Content -->
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="px-4 py-6 sm:px-0">
          <div class="border-4 border-dashed border-gray-200 rounded-lg h-96"></div>
        </div>
        <!-- /End replace -->
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import ThemeToggleButton from '../Component/ThemeToggleButton.vue';
import { useStore } from 'vuex';

const isDropdownOpen = ref(false);
const route = useRoute();
const user = ref({
  name: '',
  image: '',
});

const store = useStore();

onMounted(() => {
  if (route.query.user) {
    user.value = JSON.parse(route.query.user);
  }
});

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

</script>

<style scoped>
/* Add any custom styles here */
</style>
