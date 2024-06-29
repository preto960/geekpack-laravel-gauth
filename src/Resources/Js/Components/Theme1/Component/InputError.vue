<script setup>
import { computed } from 'vue';

const props = defineProps({
    message: [String, Array],
});

const messages = computed(() => {
    return Array.isArray(props.message) ? props.message : [props.message];
});
</script>

<template>
    <div v-if="messages.length">
        <p v-for="(msg, index) in messages" :key="index" class="text-sm text-red-600 dark:text-red-400">
            {{ msg }}
        </p>
    </div>
</template>

<style scoped>
/* Añadir estilos personalizados aquí */
</style>
