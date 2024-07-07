<template>
    <div>
        <i class="pi pi-clock mr-2 text-gray-600 dark:text-gray-400"></i>
        <span class="text-gray-800 dark:text-gray-200">{{ currentTime }}</span>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const currentTime = ref('');

    // función para actualizar la hora actual
    function updateCurrentTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    currentTime.value = `${hours}:${minutes}:${seconds}`;
    }

    // hook de ciclo de vida para iniciar y detener la actualización
    onMounted(() => {
    updateCurrentTime();
    setInterval(updateCurrentTime, 1000);
    });
</script>

<style scoped>
/* No es necesario agregar estilos específicos aquí para Tailwind CSS */
</style>
  