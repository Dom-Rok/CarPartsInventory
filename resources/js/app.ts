import './bootstrap';
import '../sass/app.scss';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { createApp, DefineComponent, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import GlobalLayout from './Layouts/GlobalLayout.vue';

 
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
 
createInertiaApp({
  title: () => `Inventory`,
  resolve: (name) => {
   const pages = import.meta.glob<DefineComponent>('./Pages/**/*.vue', { eager: true });
    
    // Fix 1: Correct variable declaration (was: let = page=pages[...])
    const page = pages[`./Pages/${name}.vue`];
    
    // Fix 2: Correct typo 'laytout' → 'layout', and use 'page' not 'pages'
    // Fix 3: Check if page exists before accessing default
    if (page?.default) {
      page.default.layout = page.default.layout || GlobalLayout;
    }
    
    return page;
  },
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use( ZiggyVue)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});