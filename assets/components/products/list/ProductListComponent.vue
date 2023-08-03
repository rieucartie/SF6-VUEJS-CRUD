<template>
  <div class="container">
    <div class="row justify-content-center mt-2 mb-2">
      <div class="col-8">
        <h4 class="text-left mb-2">Tous les produits</h4>
      </div>
    </div>
    <div class="">
      <div class="form-group">
        <router-link
            to="/products/create"
            class="btn btn-secondary mr-2"
        >
          Ajouter
        </router-link>
      </div>
      <input type="text" class="form-control"placeholder="trouver un produit..."  v-model="query.search"  @input="searchProducts" />
<br>
      <div class="">
        <div class="" v-if="!isLoading">
          <div class="row border-bottom border-top p-2 bg-light">
            <div class="col-1"> </div>
            <div class="col-3"> Nom </div>
            <div class="col-2"> Prix </div>
            <div class="col-3"> Description </div>
            <div class="col-2">Actions </div>
          </div>


            <div v-if="this.query.search">
              <div v-for="(item) in getProductsBySearch" :key="item.id">
                <product-search-detail :product="item" />
              </div>
            </div>
            <div v-else>
              <div v-for="(item, index) in products " :key="item.id" >
                <product-detail :index="index" :product="item" />
              </div>
            </div>

        </div>
        <div v-if="isLoading" class="text-center mt-5 mb-5">
          Chargement des produits...
          <div class="spinner-grow" role="status">
            <span class="sr-only">Chargement...</span>
          </div>
        </div>
      </div>
      </div>
    </div>

</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ProductDetail from "../list/ProductDetail";
import ProductSearchDetail from "./ProductSearchDetail";

export default {
  name: 'products',
  data() {
    return {
      products: [],
      productsBySearch: [],// de type '[{"id":12,"title":"carotte","price":1.0,"description":"france"}]'
      query: {
        search: "",
      },
    };
  },
  components: {
    ProductSearchDetail,
    ProductDetail
  },

  computed: {
    ...mapGetters(["isLoading",'getProductsBySearch']),

  },

  methods: {
    ...mapActions(["fetchAllProducts" ]),

    searchProducts() {
        this.$store.dispatch('fetchAllProducts', { search: this.query.search });
      },
  },

  watch: {
    'query.search': function() {
      this.$store.dispatch('fetchAllProducts', { search: this.query.search })
          .then(response => {
            this.productsBySearch = response.productsBySearch;
          });
    }
  },

  created() {
    this.$store.dispatch('fetchAllProducts')
        .then( products => {
          this.products = products;
        });
  },

};
</script>


