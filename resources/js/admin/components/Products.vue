<template>
  <div class="container">
    <h3>
      Products
      <small class="text-muted">You can mange your products</small>
    </h3>
    <b-button block :to="{name: 'newProduct'}" variant="outline-success">Add new product</b-button>
    <b-table
      fixed
      hover
      responsive
      :items="items"
      :fields="fields"
      :per-page="perPage"
      :current-page="currentPage"
    >
      <template slot="id" slot-scope="data">{{ data.value }}</template>
      <template slot="in_stock" slot-scope="data">
        <i class="fa fa-circle text-danger" v-if="data.value==0"></i>
        <i class="fa fa-circle text-success" v-else></i>
      </template>
      <template slot="image" slot-scope="data">
        <b-img :src="data.value.path" thumbnail rounded alt="Fluid image" width="50%"></b-img>
      </template>
      <template slot="id" slot-scope="data">
        <i class="fa fa-trash delete-icon" @click="toggleModal(data.value)"></i>
        <router-link :to="{ name: 'editProduct', params: { id: data.value } }">
          <i class="fa fa-edit edit-icon"></i>
        </router-link>
        <!-- <b-button id="show-btn" @click="$bvModal.show('bv-modal-example')">Open Modal</b-button> -->
      </template>
    </b-table>
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="my-table"
    ></b-pagination>

    <b-modal ref="my-modal" hide-footer hide-header>
      <div class="d-block text-center">
        <h3>Are you sure to delete this product?</h3>
      </div>
      <b-button
        class="mt-2"
        variant="outline-success"
        block
        @click="confirmeDelete(messageToDelete == null ? '' : messageToDelete)"
      >Yes</b-button>
    </b-modal>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Products",
  data() {
    return {
      perPage: 3,
      currentPage: 1,
      productToDelete: null,
      messageToDelete: null,
      fields: [
        {
          key: "name",
          sortable: true
        },
        {
          key: "desc",
          sortable: true
        },
        {
          key: "in_stock"
        },
        {
          key: "image"
        },
        {
          key: "id",
          sortable: false
        }
      ],
      items: []
    };
  },
  mounted() {
    this.getProducts();
  },
  methods: {
    getProducts() {
      axios.get("/products").then(res => {
        this.items = res.data;
      });
    },
    myRowClickHandler(record, index) {
      this.$router.push({ name: "editProduct", params: { id: record.id } });
    },
    toggleModal(productToDelete) {
      this.$refs["my-modal"].show();
      this.messageToDelete = productToDelete;
    },
    confirmeDelete(productId) {
      console.log(productId);
      axios.post("/products/delete", { id: productId }).then(res => {
        // this.$route.push({ path: "/admin/products" });
        this.getProducts();
        this.$refs["my-modal"].hide();
      });
    }
  },
  computed: {
    rows() {
      return this.items.length;
    }
  }
};
</script>