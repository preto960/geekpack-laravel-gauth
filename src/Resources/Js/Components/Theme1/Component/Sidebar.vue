<template>
    <aside :class="asideClasses" class="bg-white dark:bg-gray-800 shadow-lg">
      <!-- Logo y toggle -->
      <div class="flex items-center justify-between p-4">
        <div class="flex items-center">
          <img src="https://via.placeholder.com/150" alt="Logo" class="h-8 w-auto">
        </div>
      </div>

      <!-- Menú -->
      <nav class="px-2 py-4">
        <ul>
          <li class="relative" v-for="(item, index) in menuItems" :key="index">
            <template v-if="item.subMenu">
              <button @click="toggleSubMenu(index)" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium w-full focus:outline-none dark:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <svg v-if="!isMinimized" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <span v-if="!isMinimized">{{ item.title }}</span>
              </button>
            </template>
            <template v-else>
              <button class="flex items-center space-x-2 px-4 py-2 text-sm font-medium w-full focus:outline-none dark:text-white">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <span v-if="!isMinimized">{{ item.title }}</span>
              </button>
            </template>
            <!-- Submenú -->
            <transition v-if="item.subMenu" name="fade">
              <ul v-if="activeSubMenu === index && item.subMenu" class="ml-4">
                <li v-for="(subItem, subIndex) in item.subMenu" :key="subIndex">
                  <Link :to="subItem.route" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium dark:text-white">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                    <span v-if="!isMinimized">{{subItem.title}}</span>
                  </Link>
                </li>
              </ul>
            </transition>
          </li>
        </ul>
      </nav>
    </aside>
</template>

<script setup>
import { ref,defineProps,computed } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
  isMinimized: Boolean,
});

const activeSubMenu = ref(null);

const menuItems = [
  { title: 'Dashboard', route: '/' },
  {
    title: 'Usuarios',
    subMenu: [
      { title: 'Listado', route: '/users' },
      { title: 'Agregar', route: '/users/add' }
    ]
  },
  // Añade más elementos de menú y submenús según sea necesario
];

const toggleSubMenu = (index) => {
  if (activeSubMenu.value === index) {
    activeSubMenu.value = null;
  } else {
    activeSubMenu.value = index;
  }
}

const asideClasses = computed(() => ({
  'w-64': !props.isMinimized,
  'w-16': props.isMinimized,
  'bg-white dark:bg-gray-800 shadow-lg': true
}));

</script>

<style scoped>
/* Estilos adicionales según sea necesario */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>