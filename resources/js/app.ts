import 'flowbite';
import '../css/app.css';
import './bootstrap';

import { Head, Link, createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h, onMounted } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import moment from 'moment';

import { createPinia } from 'pinia';
import Layout from './Shared/Layout.vue';

//Element UI
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Language Setup
import { createI18n, useI18n } from 'vue-i18n';

import de from "../lang/de.json";
import en from "../lang/en.json";
import es from "../lang/es.json";
import fr from "../lang/fr.json";
import it from "../lang/it.json";

const messages = {de, en, es, it, fr};
const config = {
    locale: sessionStorage.getItem('locale') || 'de',
    fallbackLocale: 'en',
    messages,
}

const translations = createI18n(config);
// Language Setup End

const getLanguages = () => {
    return [
        {code: "de", label: 'lang.de'},
        {code: "en", label: 'lang.en'},
        {code: "it", label: 'lang.it'},
        {code: "es", label: 'lang.es'},
        {code: "fr", label: 'lang.fr'},
    ]
}

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    /**
     * This code dynamically imports Vue.js components based on the page name and ensures that each im-ported
     * component has a layout property set, falling back to a default layout (Layout) if one is not
     * specified in the component itself.
     */
    resolve: (pageName): any => {

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
        page.then((module: any) => {
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
        createApp({ render: () => h(App, props), setup() { 
            onMounted(() => {
                // document.getElementById('app').dataset.page = null;
            })
        }})
            .use(plugin)
            .component('Link', Link)//global registration of Link
            .component('Head', Head)//global registration of Head
            .use(ZiggyVue, Ziggy)
            .use(ElementPlus)
            .use(createPinia())
            .use(translations)
            .mixin({ 
                methods: { 
                    moment: moment,
                    getLanguages: getLanguages, 
                },
            })
            .mount(el);
    },

    progress: {
        color: 'red',
    },
});
