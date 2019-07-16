window.Vue = require('vue');
import Router from 'vue-router';
import VueImg from 'v-img';
// router file
import router from './routes';
// store
import store from './store';
// datatable
Vue.use(Router);
Vue.use(VueImg);

Vue.component('landing-app', require('./components/Landing/Landing.vue').default);
Vue.component('HeaderComponent', require('./components/Header/HeaderComponent.vue').default);
Vue.component('GridComponent', require('./components/Grid/ImagesGridComponent.vue').default);
Vue.component('DataTable', require('./components/DataTable/DataTable.vue').default);



const app = new Vue({
    el: '#app',
    router,
    store

});
