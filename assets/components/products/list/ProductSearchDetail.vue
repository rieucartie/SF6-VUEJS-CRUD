<template>
  <div class="row border-1 p-2">
    <div class="col-1 text-left">
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


    </div>
  </div>
</template>

<script>

export default {
  name: "ProductSearchDetail",
  props: {
    product: {
      type: Object ,
      required: true,
    }
  },


};
</script>
