<template>
    <div class="relative">
        <Link v-if="!isLoggedIn"
          :href="route('login')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Log in
      </Link>
      <Link v-if="!isLoggedIn"
          :href="route('register')"
          class="rounded-md px-3 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
      >
          Register
      </Link>
      <div v-else class="relative">
        <button @click="toggleDropdown" class="flex items-center focus:outline-none">
          <Avatar :image="`https://ui-avatars.com/api/?name=${ user.name }&color=7F9CF5&background=EBF4FF`" shape="circle" />
          <span class="ml-2 dark:text-white">{{ user.name }}</span>
        </button>
        <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border dark:border-gray-700 rounded shadow-lg">
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Profile</a>
          <a href="#" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Settings</a>
          <a href="#" @click="logout()" class="block px-4 py-2 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700">Logout</a>        
        </div>
      </div>
    </div>
</template>
  
<script setup>
    import { ref, defineProps } from 'vue';
    import { Link, router } from '@inertiajs/vue3';
    import { useStore } from 'vuex';
    import Avatar from 'primevue/avatar';
    import { useToast } from 'primevue/usetoast';
    import axios from 'axios';

    const store = useStore();
    const toast = useToast();

    const dropdownOpen = ref(false);

    const user = (store.state.data !== null) ? store.state.data.user : null;

    const toggleDropdown = () => {
        dropdownOpen.value = !dropdownOpen.value;
    }

    const isLoggedIn = (store.state.data !== null) ? store.state.data.user : null;

    const logout = async () => {
      try {
          const { token_type, access_token } = store.state.data;
          
          const response = await axios.post(route('api.logout'), null, {
              headers: {
                  'Content-Type': 'application/json',
                  'Authorization': `${token_type} ${access_token}`
              }
          });

          toast.add({
            severity: 'success',
            summary: 'Success',
            detail: response.data.message,
            life: 5000,
          });

          setTimeout(() => {
            store.commit('setUser', null);
            /* const dashboardUrl = route('/');
            window.location.href = dashboardUrl; */

            router.replace('/');
          }, 5000);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          form.errors = error.response.data.errors;
        } else {
          toast.add({
            severity: 'error',
            summary: 'Logout Failed',
            detail: error.response.data.message || 'An error occurred.',
            life: 3000,
          });
        }
      }
    }
    
</script>
  
<style scoped>
/* Agrega tus estilos aquí si es necesario */
</style>
  