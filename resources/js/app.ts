import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Head } from '@inertiajs/vue3';
// import Layout from './Shared/Layout.vue';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const customDarkTheme = {
    dark: true,
    colors: {
        'primary': '#7367F0',
        'on-primary': '#fff',
        'secondary': '#A8AAAE',
        'on-secondary': '#fff',
        'success': '#28C76F',
        'on-success': '#fff',
        'info': '#00CFE8',
        'on-info': '#fff',
        'warning': '#FF9F43',
        'on-warning': '#fff',
        'error': '#EA5455',
        'background': '#25293C',
        'on-background': '#D0D4F1',
        'surface': '#2F3349',
        'on-surface': '#D0D4F1',
        'grey-50': '#26293A',
        'grey-100': '#2F3349',
        'grey-200': '#26293A',
        'grey-300': '#4A5072',
        'grey-400': '#5E6692',
        'grey-500': '#7983BB',
        'grey-600': '#AAB3DE',
        'grey-700': '#B6BEE3',
        'grey-800': '#CFD3EC',
        'grey-900': '#E7E9F6',
        'perfect-scrollbar-thumb': '#4A5072',
        'skin-bordered-background': '#2f3349',
        'skin-bordered-surface': '#2f3349',
    },
    variables: {
        'code-color': '#d400ff',
        'overlay-scrim-background': '#101121',
        'tooltip-background': '#5E6692',
        'overlay-scrim-opacity': 0.6,
        'hover-opacity': 0.04,
        'focus-opacity': 0.12,
        'selected-opacity': 0.06,
        'activated-opacity': 0.16,
        'pressed-opacity': 0.14,
        'dragged-opacity': 0.1,
        'disabled-opacity': 0.42,
        'border-color': '#D0D4F1',
        'border-opacity': 0.16,
        'high-emphasis-opacity': 0.78,
        'medium-emphasis-opacity': 0.68,
        'switch-opacity': 0.4,
        'switch-disabled-track-opacity': 0.4,
        'switch-disabled-thumb-opacity': 0.8,
        'switch-checked-disabled-opacity': 0.3,

        // Shadows
        'shadow-key-umbra-color': '#0F1422',
    },
};

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customDarkTheme",
        themes: {
            customDarkTheme,
        },
    },
});

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
//     setup({ el, App, props, plugin }) {
//         createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue, Ziggy)
//             .mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    /**
     * This code dynamically imports Vue.js components based on the page name and ensures that each im-ported
     * component has a layout property set, falling back to a default layout (Layout) if one is not
     * specified in the component itself.
     */
    resolve: (pageName) => {

        /**
         * FINDING THE PAGE
         * This code creates a page.  It resolves the Vue.js component associated with a specific page
         * based on the pageName argument. It does this by dynamically importing the component using
         * import.meta.glob. In this case, it's looking for .vue files within the ./Pages directory and
         * its subdirectories.
         */
        const page = resolvePageComponent(
            `./Pages/${pageName}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );

        /**
         * ADDING THE LAYOUT.VUE
         * This code block uses the .then method on the page promise. It waits for the page promise to
         * resolve and then executes the provided callback function. Inside the callback function, it
         * modifies the layout property.
         */
        page.then((module) => {
            // If the page does not have his own private layout, then it has to use the general Layout.vue
            module.default.layout = module.default.layout /*|| Layout;*/
        });

        /**
         * Finally, the resolved page (which is a promise) is returned. This allows the caller to wait
         * for the Vue.js component to be imported before rendering the page.
         */
        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link', Link)//global registration of Link
            .component('Head', Head)//global registration of Head
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});

