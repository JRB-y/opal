import VueRouter from 'vue-router';
import Landing from './components/Landing/Landing.vue';
import Product from './components/Products/Product.vue';
import ProductsList from './components/Products/ProductsListComponent.vue';
import Studio from './components/Studio/Studio.vue';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/',
            component: Landing
        },
        {
            path: '/studio',
            component: Studio
        },
        {
            path: '/product/:id',
            component: Product,
            name: 'product'
        },
        {
            path: '/admin/products-list',
            component: ProductsList
        }
    ]
})
