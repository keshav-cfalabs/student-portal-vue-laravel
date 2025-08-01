import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import Vue3Toastify from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toastify, {
             autoClose: 3000,
  hideProgressBar: false,
  closeButton: true,
  style: {
    background: 'transparent', // Needed to not override inner styling
    boxShadow: 'none',
    padding: 0,
  },
  progressStyle: {
        background: '#eeeeeeff',

  },
            })
            .mount(el);
    },
    progress: {
        color: '#eeeeeeff',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
