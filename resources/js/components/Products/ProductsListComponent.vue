<template>
  <div class="container">
    <data-table fetch-url="/products" :columns="['id', 'name', 'img', 'desc', 'action']"></data-table>
  </div>
</template>

<script>
export default {
  name: "ProductsList",
  data() {
    return {};
  }
};
</script>
