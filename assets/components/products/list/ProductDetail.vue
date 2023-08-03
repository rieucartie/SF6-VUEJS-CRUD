<template>
  <div class="row border-1 p-2">
  <div class="col-1 text-left">
  {{ index + 1 }}
</div>
<div class="col-3">
  {{ product.title }}
</div>
<div class="col-2">
  <strong class="text-danger">{{ product.price }} €</strong>
</div>
  <div class="col-3">
    {{ product.description }}
  </div>
<div class="col-3">
  <router-link
      :to="{ name: 'ProductEdit', params: { id: product.id } }"
      class="btn btn-primary mr-2"
      title="Edit Product"
  >Modifier
    <i class="fa fa-pencil" />
  </router-link>
  <button class="btn btn-danger mx-2" @click="handleDelete(product.id)"> Supprimer </button>
</div>
</div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import axios from "axios";

export default {
  name: "ProductDetail",
  data() {
    return {
      isDeleting: false,
    }
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
    index: {
      type: Number,
      required: true,
      default: 0,
    },
  },

  watch: {
    isDeleting(newVal) {
      if (!newVal) {
        this.$router.go();
      }
    },
  },

  computed: { ...mapGetters([ "deletedData"]) },

  methods: {
    ...mapActions(["fetchAllProducts","deleteProduct"]),

    async handleDelete(id) {
      this.isDeleting = true;
      try {
        await this.deleteProduct(id);
        this.isDeleting = false;
        // Rafraîchir les données en appelant la méthode fetchProducts
        //await this.fetchProducts();
      } catch (error) {
        console.log("error", error);
        this.isDeleting = false;
      }
    },
    async fetchProducts() {
      // Appel de l'API pour récupérer les données mises à jour des produits
      const response = await axios.get("/products");
      const updatedProducts = response.data;
      // Mettre à jour la liste des produits dans le store Vuex
      this.$store.commit("setProducts", updatedProducts);
    },
  },
};
</script>
