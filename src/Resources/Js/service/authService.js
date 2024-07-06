// src/services/authService.js
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import Cookies from 'js-cookie';
import Swal from 'sweetalert2';
import axios from 'axios';
import { useStore } from 'vuex';

let intervalId = null;

const store = useStore();

export function setCookie(name, value, minutes) {
  const expirationDate = new Date(new Date().getTime() + minutes * 60 * 1000);
  Cookies.set(name, value, { expires: expirationDate });
}

export function getCookie(name) {
  return Cookies.get(name);
}

export function startCookieCheck() {
  intervalId = setInterval(checkCookie, 1000); // Comprobar cada segundo
}

export function stopCookieCheck() {
  clearInterval(intervalId); // Detener la verificación
}

function checkCookie() {
  if (!getCookie('miCookie')) {
    onCookieExpire();
    stopCookieCheck(); // Dejar de comprobar una vez que la cookie ha expirado
  }
}

function onCookieExpire() {
  console.log('La cookie ha expirado.');
  Swal.fire({
    title: 'Sesión Expirada',
    text: "¿Deseas permanecer en la sesión?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Permanecer',
    cancelButtonText: 'Cerrar Sesión'
  }).then((result) => {
    if (result.isConfirmed) {
      refreshToken();
    } else {
      logout();
    }
  });
}

async function refreshToken() {
  try {
    const { token_type, access_token } = store.state.data;
    // Aquí llamas a tu API para obtener un nuevo token
    const response = await axios.post(route('api.refresh'), {
        refresh_token: `${access_token}`,
      }, {
        headers: {
          'Accept': 'application/json',
          'Authorization': `${token_type} ${access_token}`
        }
      });

    if (!response.ok) {
      throw new Error('Error al refrescar el token');
    }

    const data = await response.json();
    // Aquí actualizas tu cookie con el nuevo token y tiempo de expiración
    setCookie('miCookie', data.newToken, 60);
    startCookieCheck(); // Reiniciar el intervalo
  } catch (error) {
    console.error('Error al refrescar el token:', error);
  }
}

async function logout() {
  try {
    const { token_type, access_token } = store.state.data;
  
    const response = await axios.post(route('api.logout'), null, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `${token_type} ${access_token}`
        }
    });

    if (!response.ok) {
      throw new Error('Error al cerrar la sesión');
    }

    Cookies.remove('miCookie');
      store.commit('setUser', null);
    console.log('Sesión cerrada.');
    // Aquí puedes redirigir al usuario a la página de login o realizar otras acciones necesarias
  } catch (error) {
    console.error('Error al cerrar la sesión:', error);
  }
}
