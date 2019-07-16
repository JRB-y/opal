window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue';
import VueImg from 'v-img';
// router file
Vue.use(VueImg);
Vue.use(BootstrapVue);

// Vue.component('landing-app', require('./components/Landing/Landing.vue').default);

const app = new Vue({
    el: '#app',
});
