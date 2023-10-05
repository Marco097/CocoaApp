<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="row">
        <div class="col-sm-4" v-for="(item, index) in productos" :key="index">
          <div class="card">
            <img :src="`/images/productos/${item.imagen}`" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-bold">{{ item.nombre }}&nbsp;{{ item.relleno.nombre }}</h5>
              <p class="card-text">Precio <b class="text-warning">${{ item.precio }}</b></p>
              <div class="input-group mb-3">
                <input type="number" v-model="item.cantidad" min="1" class="form-control col-3" placeholder="Cantidad">
                <a href="#" class="btn btn-primary" @click="addToReserva(item, item.cantidad)">Agregar</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],
  data() {
    return {
      showModal: false,
      productos: [],
      reservaForm: {
        id: null,
        user: null,
        detallePedido: [],
        cantidad: null,
      },
      productoSeleccionado: null,
      imagePreview: null,
      mostrarProducto: -1,
      search: "",
      sabores: [],
      rellenos: [],
      coberturas: [],
    };
  },
  methods: {
    async fetchProductos() {
      let me = this;
      await this.axios.get("/productos-reservas").then((response) => {
        console.log(response.data);
        me.productos = response.data.map((item) => ({
          ...item,
          cantidad: 0,
        }));
      });
    },
    // async fetchCoberturas() {
    //   let me = this;
    //   await this.axios.get("/coberturas").then((response) => {
    //     console.log(response.data);
    //     me.coberturas = response.data;
    //   });
    // },
    // showProducto(item) {
    //   let me = this;
    //   this.productoSeleccionado = item;
    //   this.showModal = true;
    // },
    addToReserva(item, cantidad) {
      if (cantidad > 0) {
        this.reservaForm.detallePedido.push({
          id: null,
          cantidad: cantidad,
          producto: item,
        });
      }
    },
  },
  mounted() {
    this.fetchProductos();
    //this.fetchCoberturas();
    console.log(this.user);
  },
};
</script>
