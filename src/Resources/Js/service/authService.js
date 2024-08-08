import Swal from 'sweetalert2';
import axios from 'axios';
import { router } from '@inertiajs/vue3';

let intervalId = null;
let isAlertShown = false;
let lastActivityTime = Date.now();
let INACTIVITY_LIMIT = 0;
let countdownIntervalId = null;

// User activity listeners
function updateLastActivityTime() {
  lastActivityTime = Date.now();
}

document.addEventListener('mousemove', updateLastActivityTime);
document.addEventListener('click', updateLastActivityTime);
document.addEventListener('keydown', updateLastActivityTime);

export function startExpirationCheck(store, toast) {
  if (intervalId) {
    clearInterval(intervalId);
  }
  
  // Calculate inactivity limit based on expiration date
  if (store.state.data && store.state.data.time_expire) {
    const expirationDate = new Date(store.state.data.time_expire).getTime();
    const currentTime = Date.now();
    INACTIVITY_LIMIT = expirationDate - currentTime;
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
  const expirationDate = (store.state.data !== null ? store.state.data.time_expire : null);
  const currentTime = Date.now();
  
  if (expirationDate && now >= expirationDate && store.state.data && !isAlertShown) {
    if ((currentTime - lastActivityTime > INACTIVITY_LIMIT) === true) {
      stopExpirationCheck();
      onSessionExpire(store, toast);
    } else {
      refreshToken(store, toast, 1);
    }
  }
}

function onSessionExpire(store, toast) {
  isAlertShown = true;
  let countdown = 60;

  const countdownElement = document.createElement('span');
  countdownElement.id = 'countdown';
  countdownElement.style.marginLeft = '10px';
  countdownElement.style.color = 'white';
  countdownElement.textContent = `(${countdown}s)`;

  Swal.fire({
    title: 'Session Expired',
    text: "Do you want to stay logged in?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Stay Logged In',
    cancelButtonText: `Logout ${countdownElement.outerHTML}`,
    allowOutsideClick: false,
    allowEscapeKey: false,
    didOpen: () => {
      countdownIntervalId = setInterval(() => {
        countdown--;
        document.getElementById('countdown').textContent = `(${countdown}s)`;
        if (countdown <= 0) {
          clearInterval(countdownIntervalId);
          Swal.close();
          logout(store, toast);
        }
      }, 1000);
    },
    willClose: () => {
      clearInterval(countdownIntervalId);
    }
  }).then((result) => {
    isAlertShown = false;

    if (result.isConfirmed) {
      refreshToken(store, toast);
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      logout(store, toast);
    }
  });
}

async function refreshToken(store, toast, type = null) {
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
      throw new Error('Error refreshing token');
    }

    const data = response.data;

    if (type !== null) {
      store.commit('setAccessToken', data.access_token);
      store.commit('setTimeToken', data.time_expire);
      
      startExpirationCheck(store, toast);
    } else {
      toast.add({
        severity: 'success',
        summary: 'Success',
        detail: 'Session refreshed successfully',
        life: 2000,
      });
      
      store.commit('setAccessToken', data.access_token);
      store.commit('setTimeToken', data.time_expire);

      startExpirationCheck(store, toast);

      window.location.reload();
    }
  } catch (error) {
    console.error('Error refreshing token:', error);
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
      throw new Error('Error logging out');
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
    console.error('Error logging out:', error);
  }
}
