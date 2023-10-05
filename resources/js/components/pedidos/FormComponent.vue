<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="row">
        <div class="col-sm-4" v-for="(item, index) in productos" :key="index">
          <div class="card">
            <img :src="`/images/productos/${item.imagen}`" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title text-bold">{{ item.nombre }}&nbsp;{{ item.relleno.nombre }}</h5>
<<<<<<< HEAD
              <p class="card-text">Precio <b class="text-warning">${{ item.precio }}</b></p>
              <div class="input-group mb-3">
                <input type="number" v-model="item.cantidad" min="1" class="form-control col-3" placeholder="Cantidad">
                <a href="#" class="btn btn-primary" @click="addToReserva(item, item.cantidad)">Agregar</a>
              </div>
=======
              <p class="card-text">Precio <b class="text-warning">${{ item.precio }}</b></p> 
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalleProductoModal" @click="showProducto(item)">Agregar</button>
>>>>>>> f0aa187b5f234c60d091b5f31174033650fb9431
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<<<<<<< HEAD
=======
<!-- Modal de detalles del producto -->
<div class="modal fade" id="detalleProductoModal" tabindex="-1" aria-labelledby="detalleProductoModalLabel" aria-hidden="true" ref="detalleProductoModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeDetalle"></button>
        </div>
        <div class="col-sm-4" >
              <div class="modal-body" v-if="productoSeleccionado">
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th scope="row">Nombre</th>
        <td>{{ productoSeleccionado.nombre }}</td>
      </tr>
      
      <tr>
        <th scope="row">Precio</th>
        <td>${{ productoSeleccionado.precio }}</td>
      </tr>
              <tr v-if="productoSeleccionado.relleno">
                <th scope="row">Relleno</th>
                <td>{{ productoSeleccionado.relleno.nombre }}</td>
              </tr>
              <tr>
                <th scope="row">Cantidad</th>
                <td><input type="number" v-model="productoSeleccionado.cantidad"></td>
              </tr>
              <tr>
                <th scope="row">Toppings</th>
                <td>
                  <div class="form-group col-12">
                            <select v-model="productoSeleccionado.cobertura_id" class="form-control">
                                <option v-for="cob in coberturas" :value="cob.id" >
                                {{ cob.nombre }}
                                </option>
                            </select>
                        </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeDetalle">Cerrar</button>
          <button type="button" class="btn btn-primary" @click="addToReserva">Agregar al carrito</button>
        </div>
      </div>
    </div>
  </div>
>>>>>>> f0aa187b5f234c60d091b5f31174033650fb9431
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
<<<<<<< HEAD
        cantidad: null,
      },
      productoSeleccionado: null,
      imagePreview: null,
=======
        //coberturas: [],
      },

      productoSeleccionado: null,
      // productoSeleccionado: {
      //   id: null,
      //   nombre: null,
      //   precio: null,
      //   cobertura: null,
      //   sabor: null,
      //   relleno: null,
      //   cantidad: new Number("0").toFixed(1),
      // },
      imagePreview:null,
>>>>>>> f0aa187b5f234c60d091b5f31174033650fb9431
      mostrarProducto: -1,
      search: "",
      sabores: [],
      rellenos: [],
<<<<<<< HEAD
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
=======
      coberturas:[],
      
    };
  },

    methods: {
  async fetchProductos() {
    let me = this;
    await this.axios.get("/productos-reservas").then((response) => {
      console.log(response.data);
      me.productos = response.data;
    });
  },
  async fetchCoberturas() {
    let me = this;
    await this.axios.get("/coberturas").then((response) => {
      console.log(response.data);
      me.coberturas = response.data;
    });
  },
  showProducto(item) {
    //this.$('#detalleProductoModal').modal('show');
      let me = this;
    //  console.log("No funciona");
    //  let clicks = 0;
    //  clicks++;
    //  console.log(clicks);
      //$('#detalleProductoModal').modal('show');
      this.productoSeleccionado = item;
      this.showModal = true;
    //  me.imagePreview = "/images/productos/" + item.imagen;
    //  this.showModal = true;

  },
  closeDetalle() {
    this.showModal = false;
    //this.productoSeleccionado = null;
  },
  addToReserva() {
    // Agrega el producto al carrito
    this.reservaForm.detallePedido.push({
      id: null,
      cantidad: this.reservaForm.cantidad,
      producto: this.productoSeleccionado,
      cobertura: this.reservaForm.cobertura,
    });
    this.showModal = false; // Cerrar el modal después de agregar al carrito
  },

>>>>>>> f0aa187b5f234c60d091b5f31174033650fb9431
  },
  mounted() {
    this.fetchProductos();
    //this.fetchCoberturas();
    console.log(this.user);
  },
};
</script>