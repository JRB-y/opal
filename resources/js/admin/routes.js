import VueRouter from 'vue-router';
import Products from './components/Products';
import NewProduct from './components/NewProduct';
import EditProduct from './components/EditProduct.vue';
import Dashboard from './components/DashboardComponent';

export default new VueRouter({
    mode: 'history',
    routes: [{
            path: '/admin',
            component: Dashboard,
            name: 'dashboard'
        },
        {
            path: '/admin/products',
            component: Products,
            name: 'products'
        },
        {
            path: '/admin/new-product',
            component: NewProduct,
            name: 'newProduct'
        },
        {
            path: '/admin/products/edit/:id',
            component: EditProduct,
            name: 'editProduct'
        }
    ]
})
