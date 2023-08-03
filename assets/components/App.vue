<template>
  <div>
    <div :show="isLoading">
      <navbar />
        <router-view />
    </div>
  </div>
</template>

<style scoped></style>

<script>
import Navbar from "./Navbar";
import { mapGetters } from "vuex";

export default {
  name: "App",
  components: {
    Navbar,
  },
  computed: {
    ...mapGetters({
      isLoading: "getLoading",
    }),
  },
};
</script>
