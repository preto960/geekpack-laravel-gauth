<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Verify Email</h2>
        <p class="text-center mt-4">
          A verification link has been sent to your email address. Please check your email and click the link to verify your account.
        </p>
        <form @submit.prevent="resendVerificationLink" class="mt-6">
          <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg">Resend Verification Link</button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import axios from 'axios';
  
  const resendVerificationLink = async () => {
    try {
      await axios.post('/api/email/verification-notification');
    } catch (error) {
      console.error(error);
    }
  };
  </script>
  
  <style scoped>
  /* Añadir estilos personalizados aquí */
  </style>
  