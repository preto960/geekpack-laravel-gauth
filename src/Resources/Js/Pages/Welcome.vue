<template>
    <LandingPage />
</template>
  
<script setup>
  import LandingPage from '../Components/'+theme+'/LandingPage.vue';

  defineProps({
      canLogin: {
          type: Boolean,
      },
      canRegister: {
          type: Boolean,
      },
      laravelVersion: {
          type: String,
          required: true,
      },
      phpVersion: {
          type: String,
          required: true,
      },
      theme: {
        type: String,
        required: true,
      }
  });
</script>
  
<style>
  /* Tailwind CSS importado aquí */
  @import 'tailwindcss/tailwind.css';
</style>