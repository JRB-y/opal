<template>
  <div class="container">
    <h3>
      Dashboard
      <small class="text-muted">Welcome</small>
    </h3>
    <b-card-group deck>
      <b-card border-variant="light" header="Products" class="text-center">
        <b-card-text>
          <i class="fa fa-gem"></i>
          {{ productsCount }}
        </b-card-text>
      </b-card>
      <b-card border-variant="light" header="Users" class="text-center">
        <b-card-text>
          <i class="fa fa-user"></i> 0
        </b-card-text>
      </b-card>
    </b-card-group>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Dashboard",
  data() {
    return {
      productsCount: ""
    };
  },
  mounted() {
    this.getProductsCount();
  },
  methods: {
    getProductsCount() {
      axios.post("/products/count").then(res => {
        this.productsCount = res.data;
      });
    }
  }
};
</script>

<style scoped>
</style>