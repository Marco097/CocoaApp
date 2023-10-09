<template>
    <!-- Contenido del carrito (se muestra al hacer clic en el icono) -->
    <div v-if="showCart" class="cart-dropdown">
      <ul class="list-group">
        <li class="list-group-item" v-for="item in cartItems" :key="item.id">
          <div class="row">
            <div class="col-lg-3">
              <img :src="item.image" style="width: 50px; height: 50px;">
            </div>
            <div class="col-lg-6">
              <b>{{ item.name }}</b>
              <br><small>Qty: {{ item.quantity }}</small>
            </div>
            <div class="col-lg-3">
              <p>${{ item.price }}</p>
            </div>
          </div>
        </li>
      </ul>
      <div class="cart-info">
        <span>Total: ${{ getTotal }}</span>
        <button class="btn btn-secondary btn-sm" @click="clearCart">Vaciar Carrito</button>
      </div>
    </div>

</template>

<script>
export default {
  data() {
    return {
      showCart: false,
      cartItems: [], // Aquí almacena los elementos del carrito
    };
  },
  computed: {
    getQuantity() {
      // Calcula la cantidad total de productos en el carrito
      return this.cartItems.reduce((total, item) => total + item.quantity, 0);
    },
    getTotal() {
      // Calcula el total de la compra
      return this.cartItems.reduce((total, item) => total + item.price * item.quantity, 0);
    },
  },
  methods: {
    toggleCart() {
      this.showCart = !this.showCart;
    },
    clearCart() {
      // Lógica para vaciar el carrito
      this.cartItems = [];
      this.showCart = false;
    },
    // Resto de los métodos para agregar, eliminar y gestionar productos en el carrito
  },
};
</script>

<style scoped>
/* Estilos CSS para el componente */
.cart-dropdown {
  position: absolute;
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  padding: 10px;
  right: 0;
  top: 60px;
  width: 300px;
  z-index: 1;
  text-align: left;
}
</style>

