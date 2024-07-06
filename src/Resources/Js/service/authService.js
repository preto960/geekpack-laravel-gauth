import Swal from 'sweetalert2';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

let intervalId = null;
let isAlertShown = false;

export function startExpirationCheck(store, toast) {
  if (intervalId) {
    clearInterval(intervalId);
  }
  intervalId = setInterval(() => {
    checkExpiration(store, toast);
  }, 1000);
}

export function stopExpirationCheck() {
  clearInterval(intervalId);
  intervalId = null;
}

function checkExpiration(store, toast) {
  const now = new Date().toISOString();
  const expirationDate = (store.state.data !== null ? store.state.data.time_expire:null);

  if (expirationDate && now >= expirationDate && store.state.data && !isAlertShown) {
    stopExpirationCheck();
    onSessionExpire(store, toast);
  }
}

function onSessionExpire(store, toast) {
  isAlertShown = true;

  Swal.fire({
    title: 'Sesión Expirada',
    text: "¿Deseas permanecer en la sesión?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Permanecer',
    cancelButtonText: 'Cerrar Sesión',
    allowOutsideClick: false,
    allowEscapeKey: false
  }).then((result) => {
    isAlertShown = false;

    if (result.isConfirmed) {
      refreshToken(store, toast);
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      logout(store, toast);
    }
  });
}

async function refreshToken(store, toast) {
  try {
    const { token_type, access_token } = store.state.data;

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

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: 'La sesión ha sido refrescada',
      life: 2000,
    });

    const data = response.data;

    store.commit('setAccessToken', data.access_token);
    store.commit('setTimeToken', data.time_expire);
    
    startExpirationCheck(store, toast);

    window.location.reload();
  } catch (error) {
    console.error('Error al refrescar el token:', error);
  }
}

async function logout(store, toast) {
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

    toast.add({
      severity: 'success',
      summary: 'Success',
      detail: response.data.message,
      life: 2000,
    });

    store.commit('setUser', null);
    
    router.replace('/');
    
  } catch (error) {
    console.error('Error al cerrar la sesión:', error);
  }
}
