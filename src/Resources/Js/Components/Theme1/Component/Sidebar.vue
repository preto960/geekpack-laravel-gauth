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
            <button @click="toggleSubMenu(index)" class="flex items-center justify-between space-x-2 px-4 py-2 text-sm font-medium w-full focus:outline-none dark:text-white">
              <div class="flex items-center space-x-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <span v-if="!isMinimized">{{ item.title }}</span>
              </div>
              <!-- Flecha al lado derecho con rotación -->
              <svg :class="{'rotate-180': activeSubMenu === index}" class="ml-auto h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
          </template>
          <template v-else>
            <Link :href="item.route" :class="{'bg-gray-200 dark:bg-gray-700': item.route === activeRoute}" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium w-full focus:outline-none dark:text-white">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
              </svg>
              <span v-if="!isMinimized">{{ item.title }}</span>
            </Link>
          </template>
          <!-- Submenú -->
          <transition v-if="item.subMenu" name="fade">
            <ul v-if="activeSubMenu === index" class="ml-4">
              <li v-for="(subItem, subIndex) in item.subMenu" :key="subIndex">
                <Link :href="subItem.route" :class="{'bg-gray-200 dark:bg-gray-700': subItem.route === activeRoute}" class="flex items-center space-x-2 px-4 py-2 text-sm font-medium dark:text-white">
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
import { ref, defineProps, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
  isMinimized: Boolean,
});

const activeSubMenu = ref(null);
const activeRoute = ref('');

const menuItems = [
  { title: 'Dashboard', route: '/dashboard' },
  {
    title: 'Usuarios',
    subMenu: [
      /* { title: 'Dashboard', route: '/dashboard' }, */
      { title: 'Listado', route: '/users' },
      { title: 'Agregar', route: '/users/add' }
    ]
  },
  // Añade más elementos de menú y submenús según sea necesario
];

// Detectar la ruta activa al cargar la página
onMounted(() => {
  activeRoute.value = window.location.pathname;

  // Encontrar si la ruta actual pertenece a un submenú y activarlo
  menuItems.forEach((item, index) => {
    if (item.subMenu) {
      item.subMenu.forEach(subItem => {
        if (subItem.route === activeRoute.value) {
          activeSubMenu.value = index;
        }
      });
    } else if (item.route === activeRoute.value) {
      activeSubMenu.value = index;
    }
  });
});

const toggleSubMenu = (index) => {
  // Si haces clic en el mismo submenú, no se cerrará
  if (activeSubMenu.value === index) {
    activeSubMenu.value = null;
  } else {
    activeSubMenu.value = index;
  }
};

const asideClasses = computed(() => ({
  'w-64': !props.isMinimized,
  'w-16': props.isMinimized,
  'bg-white dark:bg-gray-800 shadow-lg': true
}));
</script>
