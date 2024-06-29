import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css';

import Wind from '../css/presets/Wind';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Components/${template}/Pages/${name}.vue`, import.meta.glob(`./Components/${template}/Pages/**/*.vue`)),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, { 
                ripple: true,
                unstyled: true,
                pt: Wind
             })
            .use(ConfirmationService)
            .use(ToastService)
            .mount(el);
    }
});
