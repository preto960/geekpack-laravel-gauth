<template>
  <AppLayout>
    <Head title="Profile" />
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold mb-6 dark:text-gray-200">User Profile</h1>
      <div class="flex flex-col md:flex-row gap-6">
        <!-- Profile card on the left -->
        <div class="w-full md:w-1/3">
          <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex flex-col items-center">
              <div class="w-48 h-48 mb-6 rounded-lg overflow-hidden border-4 border-gray-200 dark:border-gray-600 shadow-lg">
                <img v-if="$getUser('avatar')" :src="user.avatar" alt="Avatar" class="w-full h-full object-cover">
                <Avatar v-else :image="`https://ui-avatars.com/api/?name=${ $getUser('fullname') }&color=7F9CF5&background=EBF4FF`" class="w-full h-full" />
              </div>
              <h2 class="text-2xl font-semibold mb-2 dark:text-gray-200">{{ $getUser('fullname') }}</h2>
              <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $getUser('email') }}</p>
              <p class="text-gray-600 dark:text-gray-400 mb-4">Member since: {{ new Date($getUser('created_at')).toLocaleDateString() }}</p>
            </div>
            <div class="mt-4">
              <h3 class="text-xl font-semibold mb-3 dark:text-gray-200">Additional Information</h3>
              <p class="text-gray-600 dark:text-gray-400 mb-2">Phone: {{ $getUser('phone') || 'Not specified' }}</p>
              <p class="text-gray-600 dark:text-gray-400 mb-2">Address: {{ $getUser('address') || 'Not specified' }}</p>
              <p class="text-gray-600 dark:text-gray-400">Bio: {{ $getUser('bio') || 'No information available' }}</p>
            </div>
          </div>
        </div>
        
        <!-- Larger frame on the right -->
        <div class="w-full md:w-2/3">
          <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 h-full">
            <h2 class="text-2xl font-semibold mb-4 dark:text-gray-200">Additional Content</h2>
            <p class="text-gray-600 dark:text-gray-400">
              Here you can add more content, such as user statistics, 
              recent posts, account settings, etc.
            </p>
          </div>
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
import { useToast } from 'primevue/usetoast';

const toast = useToast();
</script>