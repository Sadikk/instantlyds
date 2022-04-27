require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import mitt from 'mitt';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const emitter = mitt()
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app: inertiaApp, props, plugin }) {
        const app = createApp({ render: () => h(inertiaApp, props) })
            .use(plugin)
            .mixin({ methods: { route } });
        app.config.globalProperties.emitter = emitter
        app.mount(el);
        return app;
    },
});

InertiaProgress.init({ color: '#4B5563' });
