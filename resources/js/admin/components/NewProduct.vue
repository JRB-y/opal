<template>
  <div>
    <h3>
      New Product
      <small class="text-muted">El asba yal jean</small>
    </h3>
    <b-alert
      v-model="productAdded"
      variant="success"
      dismissible
      fade
    >Your Product is successfully added..</b-alert>
    <b-alert v-model="productError" variant="danger" dismissible>{{ error }}</b-alert>
    <div class="row">
      <div class="col-md-12">
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
        <button @click="submit()" class="btn btn-primary" :disabled="btnDisabled">Submit</button>
      </div>
    </div>
  </div>
</template>

<script>
import PictureInput from "vue-picture-input";
import axios from "axios";

export default {
  name: "NewProduct",
  data() {
    return {
      productAdded: false,
      productError: false,
      btnDisabled: false,
      error: "",
      product: {
        name: "",
        desc: "",
        image: "",
        in_stock: ""
      },
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
  methods: {
    onChanged() {
      if (this.$refs.pictureInput.file) {
        this.product.image = this.$refs.pictureInput.file;
      } else {
        console.log("Old browser. No support for Filereader API");
      }
    },
    submit() {
      this.btnDisabled = true;
      let formData = new FormData();

      formData.append("image", this.product.image);
      formData.append("name", this.product.name);
      formData.append("desc", this.product.desc);
      formData.append("in_stock", this.product.in_stock);

      axios
        .post("/products", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {
          this.productAdded = true;
          this.product.name = "";
          this.product.desc = "";
          this.product.image = "";
          this.product.in_stock = "";
          this.btnDisabled = false;
        })
        .catch(error => {
          this.productError = true;
          this.error = error;
          this.btnDisabled = false;
        });
    }
  }
};
</script>

<style scoped>
</style>