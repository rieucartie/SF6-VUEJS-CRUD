<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h6>Ajouter un produit</h6>
      </div>
      <div class="card-body">
          <form @submit.prevent="submit">
          <div class="form-group row my-1">
            <div class="col-6">
              <label for="title">Nom :</label><input
                  id="title"
                  v-model="product.title"
                  name="title"
                  type="text"
                  class="form-control"
              />
            </div>
            <div class="col-6">
              <label>Prix :</label>

                <input
                    v-model="product.price"
                    name="price"
                    type="number"
                    class="form-control"
                />
            </div>
          </div>
          <div class="form-group row my-1">
            <div class="col-12">
              <label>Description :</label>
                <input
                    v-model="product.description"
                    name="description"
                    type="text"
                    class="form-control"
                />

            </div>
          </div>
          <div class="form-group">
            <router-link
                to="/products"
                class="btn btn-secondary mr-2"
            >
              Annuler
            </router-link>
            <input
                v-if="!isCreating"
                type="submit"
                class="btn btn-primary mx-2 my-2"
                value="Ajouter"
            >
            <button
                v-if="isCreating"
                class="btn btn-primary mx-2 my-2"
                type="button"
                disabled
            >
              <span
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
              />
              Enregistrer...
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  components: {
  },

  data() {
    return {
      product: {},
    };
  },

  computed: { ...mapGetters(["isCreating", "createdData"]) },

  watch: {
    createdData: function () {
      if (this.createdData !== null && !this.isCreating) {
        this.$router.push({ name: "ProductList" });
      }
    },
  },

  methods: {
    ...mapActions(["storeProduct"]),

    submit() {

      const { title, price, description } = this.product;
      this.storeProduct({
        title: title,
        price: price,
        description: description,
      });
    },
  },
};
</script>

