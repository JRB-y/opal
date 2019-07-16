window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue';
import Router from 'vue-router';
import VueImg from 'v-img';

import router from './routes';
// router file
Vue.use(VueImg);
Vue.use(BootstrapVue);
Vue.use(Router);

Vue.component('dashboard', require('./components/DashboardComponent').default);

const app = new Vue({
    el: '#app',
    router
});
