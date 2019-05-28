<template>
    <div class="grid">
        <figure class="gallery__item" v-for="product in products" :key="product.id">
            <router-link :to="{ name: 'product', params: { id: product.id } }">
                <img :src="product.images[0].path" class="gallery__img" alt="img" @mouseover="mouseover(product)" @mouseleave="mouseleave(product)">
            </router-link>
        </figure>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: 'ImagesGridComponent',
    data(){
        return {
            products: []
        }
    },
    created(){
        this.getImages();
    },
    methods: {
        getImages(){
            axios.get('products').then((res)=> {
                this.products = res.data;
            })
        },
        mouseover(product){
            var tmp = product.images[0].path;
            product.images[0].path = product.images[1].path;
            product.images[1].path = tmp;
        },
        mouseleave(product){
            var tmp = product.images[0].path;
            product.images[0].path = product.images[1].path;
            product.images[1].path = tmp;
        }
    }
   
}
</script>