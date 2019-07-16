<template>
  <div>
    <h3>
      Edit Product
      <small class="text-muted">Vous pouvez modifier votre produit</small>
    </h3>
    <b-alert v-model="productUpdated" variant="success" dismissible fade>Product Updated</b-alert>
    <!-- <b-alert v-model="productError" variant="danger" dismissible>{{ error }}</b-alert> -->
    <div class="form-group">
      <label for="name">Product Name</label>
      <input
        type="text"
        class="form-control"
        id="name"
        aria-describedby="emailHelp"
        placeholder="Product name"
        v-model="product.name"
      />
    </div>
    <div class="form-group">
      <b-form-textarea
        id="desc"
        v-model="product.desc"
        placeholder="A short description of the product..."
        rows="3"
        max-rows="6"
      ></b-form-textarea>
    </div>
    <div class="form-group">
      <picture-input
        ref="pictureInput"
        width="450"
        height="450"
        margin="16"
        accept="image/jpeg, image/png"
        size="10"
        button-class="btn"
        v-model="product.image"
        :prefill="prefill"
        @change="onChanged"
      ></picture-input>
    </div>
    <b-form-group label="Stock">
      <b-form-radio-group
        id="stock"
        v-model="product.in_stock"
        :options="options.stock"
        name="stock"
      ></b-form-radio-group>
    </b-form-group>

    <button @click="update()" class="btn btn-primary">Submit</button>
  </div>
</template>

<script>
import axios from "axios";
import PictureInput from "vue-picture-input";

export default {
  name: "NewProduct",
  data() {
    return {
      productUpdated: false,
      prefill: "",
      product: {},
      options: {
        stock: [
          { text: "In stock", value: 1 },
          { text: "Out of stock", value: 0 }
        ]
      }
    };
  },
  components: {
    PictureInput
  },
  mounted() {
    this.getProduct();
  },

  methods: {
    getProduct() {
      axios.get("/products/" + this.$route.params.id).then(res => {
        this.product = res.data;
        this.prefill = this.product.image.path;
      });
    },
    update() {
      let formData = new FormData();

      formData.append("image", this.product.image);
      formData.append("name", this.product.name);
      formData.append("desc", this.product.desc);
      formData.append("in_stock", this.product.in_stock);
      formData.append("id", this.product.id);

      axios
        .post("/products/update", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {
          if (res.status == 200) {
            this.productUpdated = true;
          }
        });
    },
    onChanged() {
      if (this.$refs.pictureInput.file) {
        this.product.image = this.$refs.pictureInput.file;
      } else {
        console.log("Old browser. No support for Filereader API");
      }
    }
  }
};
</script>