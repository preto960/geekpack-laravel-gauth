<template>
  <AppLayout>
    <Head title="Profile" />
    <Toast />
    <div class="max-w-4xl mx-auto py-8">
      <h1 class="text-3xl font-bold mb-6">User Profile</h1>
      <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <img v-if="$getUser('avatar')" :src="user.avatar" alt="Avatar" class="w-32 h-32 rounded-full mx-auto md:mx-0">
            <Avatar v-else :image="`https://ui-avatars.com/api/?name=${ $getUser('name') }&color=7F9CF5&background=EBF4FF`" shape="circle" />
          </div>
          <div>
            <h2 class="text-2xl font-semibold mb-2">{{ $getUser('name') }}</h2>
            <p class="text-gray-600 mb-2">{{ $getUser('email') }}</p>
            <p class="text-gray-600 mb-2">Miembro desde: {{ new Date($getUser('created_at')).toLocaleDateString() }}</p>
          </div>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-semibold mb-3">Información adicional</h3>
          <p class="text-gray-600 mb-2">Teléfono: {{ $getUser('phone') || 'No especificado' }}</p>
          <p class="text-gray-600 mb-2">Dirección: {{ $getUser('address') || 'No especificada' }}</p>
          <p class="text-gray-600">Bio: {{ $getUser('bio') || 'No hay información disponible' }}</p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { defineProps } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';

const props = defineProps({
  user: Object
})


</script>