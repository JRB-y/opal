import VueRouter from 'vue-router';
import Landing from './components/Landing/Landing.vue';
import Product from './components/Products/Product.vue';

export default  new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: Landing },
        {  path: '/product/:id', name: 'product', component: Product },
    ]
})