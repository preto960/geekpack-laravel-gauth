<template>
  <header class="flex justify-between items-center p-4 bg-white dark:bg-gray-800">
    <div class="text-xl font-bold dark:text-white">{{system.canSystemName}}</div>
    <div class="flex items-center space-x-4" v-if="system.canLogin">
      <Time />
      <ThemeToggleButton />
      <UserDropdown />
    </div>
  </header>
</template>

<script setup>
import { ref, defineProps, defineEmits, onMounted, onBeforeUnmount } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Time from './Time.vue';
import ThemeToggleButton from './ThemeToggleButton.vue';
import UserDropdown from './UserDropdown.vue';

const props = defineProps({
  isAuthenticated: Boolean,
  user: Object,
  theme: String,
  system: { type: Object }
});

</script>

<style scoped>
/* Aquí puedes añadir estilos adicionales si es necesario */
</style>
