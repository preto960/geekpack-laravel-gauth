import Cookies from 'js-cookie';
import Swal from 'sweetalert2';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

let intervalId = null;
let isAlertShown = false;

export function setCookie(name, value, minutes) {
  const expirationDate = new Date(new Date().getTime() + minutes * 60 * 1000);
  Cookies.set(name, value, { expires: expirationDate });
}

export function getCookie(name) {
  const cookieValue = Cookies.get(name);
  return cookieValue || null;
}

export function startCookieCheck(store) {
  intervalId = setInterval(() => checkCookie(store), 1000); // Comprobar cada segundo
}

export function stopCookieCheck() {
  clearInterval(intervalId); // Detener la verificación
  intervalId = null;
}

function checkCookie(store) {
  const cookie = getCookie('miCookie');
  if (!cookie && store.state.data && !isAlertShown) {
    // Si no hay cookie y el usuario está autenticado
    stopCookieCheck(); // Detener la verificación
    onCookieExpire(store); // Mostrar alerta de sesión expirada
  }
}

function onCookieExpire(store) {
  isAlertShown = true;
  Swal.fire({
    title: 'Sesión Expirada',
    text: "¿Deseas permanecer en la sesión?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Permanecer',
    cancelButtonText: 'Cerrar Sesión',
    allowOutsideClick: false, // Evitar cerrar haciendo clic fuera del SweetAlert
    allowEscapeKey: false // Evitar cerrar con la tecla Escape
  }).then((result) => {
    if (result.isConfirmed) {
      refreshToken(store); // Actualizar token y reiniciar verificación
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      logout(store); // Cerrar sesión si el usuario cancela
    }
    isAlertShown = false; // Resetear bandera
  });
}

async function refreshToken(store) {
  try {
    const { token_type, access_token } = store.state.data;
    // Llamar a la API para obtener un nuevo token
    const response = await axios.post(route('api.refresh'), {
      refresh_token: `${access_token}`,
    }, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `${token_type} ${access_token}`
      }
    });

    if (response.status !== 200) {
      throw new Error('Error al refrescar el token');
    }

    const data = response.data;
    // Actualizar la cookie con el nuevo token y tiempo de expiración
    store.commit('setAccessToken', data.access_token);
    setCookie('miCookie', data.access_token, 1);
    startCookieCheck(store); // Reiniciar verificación de la cookie
  } catch (error) {
    console.error('Error al refrescar el token:', error);
  }
}

async function logout(store) {
  try {
    const { token_type, access_token } = store.state.data;

    const response = await axios.post(route('api.logout'), null, {
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `${token_type} ${access_token}`
      }
    });

    if (response.status !== 200) {
      throw new Error('Error al cerrar la sesión');
    }

    Cookies.remove('miCookie');
    store.commit('setUser', null);
    console.log('Sesión cerrada.');
    router.replace('/');
    // Aquí puedes redirigir al usuario a la página de login u otras acciones necesarias
  } catch (error) {
    console.error('Error al cerrar la sesión:', error);
  }
}
