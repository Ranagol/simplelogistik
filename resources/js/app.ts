import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Head } from '@inertiajs/vue3';
import Layout from './Shared/Layout.vue';

//Element UI
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'



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
            module.default.layout = module.default.layout || Layout;
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
            .use(ElementPlus)
            .mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});

