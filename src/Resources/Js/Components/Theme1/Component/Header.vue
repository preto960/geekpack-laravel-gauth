<template>
  <header class="flex justify-between items-center p-4 bg-white dark:bg-gray-800">
    <div class="text-xl font-bold dark:text-white">{{system.canSystemName}}</div>
    <div class="flex items-center space-x-4" v-if="system.canLogin">
      <span>{{ currentTime }}</span>
      <ThemeToggleButton />
      <UserDropdown />
    </div>
  </header>
</template>

<script setup>
import { ref, defineProps, defineEmits, onMounted, onBeforeUnmount } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ThemeToggleButton from './ThemeToggleButton.vue';
import UserDropdown from './UserDropdown.vue';

const props = defineProps({
  isAuthenticated: Boolean,
  user: Object,
  theme: String,
  system: { type: Object }
});

const currentTime = ref('')

// función para actualizar la hora actual
function updateCurrentTime() {
  const now = new Date()
  const hours = String(now.getHours()).padStart(2, '0')
  const minutes = String(now.getMinutes()).padStart(2, '0')
  const seconds = String(now.getSeconds()).padStart(2, '0')
  currentTime.value = `${hours}:${minutes}:${seconds}`
}

// hook de ciclo de vida para iniciar y detener la actualización
onMounted(() => {
  updateCurrentTime()
  setInterval(updateCurrentTime, 1000)
})

</script>

<style scoped>
/* Aquí puedes añadir estilos adicionales si es necesario */
</style>
