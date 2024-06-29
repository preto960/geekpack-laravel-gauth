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
import store from "./store";

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const theme = store.state.theme;
document.documentElement.setAttribute('data-theme', theme);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const props = JSON.parse(app.dataset.page);
    
        if (!store.state.props) {
            store.commit('setProps', props.props);
        }

        if (!store.state.props.template) {
            throw new Error('Template is not defined in store.props');
        }

        const componentPath = `./Components/${store.state.props.template}/Pages/${name}.vue`;
        const components = import.meta.glob(`./Components/**/*.vue`);

        if (!components[componentPath]) {
            throw new Error(`Page not found: ${componentPath}`);
        }

        return components[componentPath]();
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(store)
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
