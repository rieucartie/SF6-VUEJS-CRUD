<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="info">
      <b-navbar-brand :to="{ name: 'home' }">Crud Exemple</b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item v-if="!isAuthenticated" :to="{ name: 'login' }"
            >Connexion</b-nav-item
          >
          <b-nav-item v-if="!isAuthenticated" :to="{ name: 'register' }"
            >S'enregistrer</b-nav-item
          >

          <b-nav-item v-if="isAuthenticated" :to="{ name: 'ProductList' }"
          >Produit</b-nav-item
          >

          <b-nav-item v-if="isAuthenticated" @click="submit">Déconnexion</b-nav-item>

        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<style scoped></style>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "Navbar",
  computed: {
    ...mapGetters({
      isAuthenticated: "auth/isAuthenticated",
    }),
  },
  methods: {
    ...mapActions({
      logout: "auth/logout",
    }),
    submit() {
      this.logout();
      this.$router.replace({
        name: "home",
      });
    },
  },
};
</script>
