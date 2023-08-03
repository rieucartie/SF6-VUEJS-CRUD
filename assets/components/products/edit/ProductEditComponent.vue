<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h6>Modifier le produit</h6>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="form-group row">
            <div class="col-6">
              <label>Nom: </label>
              <input type="text"
                     id="title"
                     name="title"
                     v-model="ProductDetail.title"
                     @input="updateProductInputAction"/>
            </div>
            <div class="col-6">
              <label>Prix: </label>
              <input type="number" id="price" name="price" v-model="ProductDetail.price" @input="updateProductInputAction"/>
            </div>
            <div class="form-group row my-1">
              <div class="col-12">
                <label>Description: </label>
                <input type="text" id="description" name="description" v-model="ProductDetail.description"
                       @input="updateProductInputAction"/>
              </div>
            </div>
          </div>

          <router-link
              to="/products"
              class="btn btn-secondary mr-2"
          >
            Annuler
          </router-link>

          <input
              v-if="!isUpdating"
              type="submit"
              class="btn btn-primary mx-2"
              value="Modifier"
          >
          <button
              v-if="isUpdating"
              class="btn btn-primary"
              type="button"
              disabled
          >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                />
            Modifer...
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
  components: {
  },

  data() {
    return {
      ProductDetail:[],
      id: null,
      title: '',
      price: null,
      description: '',
    };
  },

  computed: {
    ...mapGetters(["isUpdating", "updatedData", "product", "isLoading"]),
  },

  watch: {
    updatedData: function () {
      if (this.updatedData !== null && !this.isUpdating) {
        this.$router.push({ name: "ProductList" });
      }
    },
  },

  created: function () {
    this.id = this.$route.params.id;
    this.$store.dispatch('fetchDetailProduct', this.id)
        .then(productDetail => {
          this.ProductDetail = productDetail;
        })
        .catch(error => {
          console.error('Error fetching product detail in component:', error);
        });

  },

  methods: {
    ...mapActions([
      "updateProduct","updateProductInput","fetchDetailProduct"
    ]),

    submit() {
      const { title, price, description } = this.product;
      this.updateProduct({
        id: this.id,
        title : title ,
        price: price ,
        description: description ,
      });
    },

    updateProductInputAction(e) {
      this.updateProductInput(e);
    },
  },
};
</script>

