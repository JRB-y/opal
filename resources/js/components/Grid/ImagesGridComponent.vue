<template>
  <div class="grid">
    <figure class="gallery__item" v-for="product in products" :key="product.id">
      <div class="grid-box">
        <router-link :to="{ name: 'product', params: { id: product.id } }">
          <img
            :src="product.image.path"
            class="gallery__img"
            :alt="product.name"
            @mouseover="reverseImage(product)"
            @mouseleave="reverseImage(product)"
          />
        </router-link>
        <h1>{{product.name}}</h1>
      </div>
    </figure>
  </div>
</template>
<script>
import axios from "axios";

export default {
  name: "ImagesGridComponent",
  data() {
    return {
      products: [],
      offset: 0
    };
  },
  methods: {
    getImages() {
      axios.get("products-grid/" + "0").then(res => {
        this.products = res.data;
        this.offset += 12;
      });
    },
    reverseImage(product) {
      var tmp = product.image.path;

      product.image.path = product.images[0].path;

      product.images[0].path = tmp;
    },
    scroll() {
      window.onscroll = () => {
        var scrollHeight, totalHeight;
        scrollHeight = document.body.scrollHeight;
        totalHeight = window.scrollY + window.innerHeight;

        if (totalHeight >= scrollHeight) {
          axios.get("products-grid/" + this.offset).then(response => {
            this.products = this.products.concat(response.data);
            this.offset += 12;
          });

          console.log();
        }
      };
    }
  },
  mounted() {
    this.scroll();
  },
  beforeMount() {
    this.getImages();
  }
};
</script>
