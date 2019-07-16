<template>
  <div id="product">
    <h1 class="product-title">
      {{ product.name }}
      <small style="font-size: 13px; color: green;">en stock</small>
    </h1>
    <p class="desc">{{product.desc}}</p>
    <div class="product-desc">
      <img
        v-img
        v-for="image in product.images"
        :key="image.id"
        :src="image.path"
        alt="img"
        class="product-img"
      />
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { constants } from "crypto";

export default {
  name: "Product",
  data() {
    return {
      product: {}
    };
  },
  created() {
    this.getProduct(this.$route.params.id);
  },
  methods: {
    getProduct(id) {
      axios.get("/products/" + id).then(res => {
        this.product = res.data;
      });
    }
  }
};
</script>
