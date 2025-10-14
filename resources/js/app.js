import './bootstrap';

import { createApp } from 'vue';
import NowServing from './components/now-serving.vue';
import QueueCall from './components/queue-call.vue';

if (document.querySelector('#app2')) {
    const app2 = createApp({});
    app2.component('now-serving', NowServing);
    app2.component('queue-call', QueueCall);
    app2.mount('#app2');
}
