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

  <!-- Modal de detalles del producto -->
<div class="modal fade" id="detalleProductoModal" tabindex="-1" aria-labelledby="detalleProductoModalLabel" aria-hidden="true" ref="detalleProductoModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalleProductoModalLabel">Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="closeDetalle"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Precio</th>
              <th scope="col">Toppins</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{ productoSeleccionado.nombre }}</td>
              <td>${{ productoSeleccionado.precio }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="closeDetalle">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="addToReserva">Agregar al carrito</button>
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
        cantidad: new Number("0").toFixed(2),
        user: null,
        detallePedido: []
      },
      productoSeleccionado: {
        nombre: "",
        precio: 0,
        coberturas: []
      },
      imagePreview:null,
      mostrarProducto: -1,
      search: "",
      sabores: [],
      rellenos: [],
      
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
    showDetalle(item) {
      let me = this;
            $('#detalleProductoModal').modal('show');
            me.mostrarProducto = me.productos.indexOf(producto);
            me.reservaForm = Object.assign({}, producto);
            me.imagePreview ="/images/productos/"+ me.reservaForm.imagen;
            this.showModal = true;
        },

        //this.productoSeleccionado = item; // Almacena el producto seleccionado
     // this.showModal = true; 
    closeDetalle() {
      this.showModal = false;
    },

    addToReserva() {
      // Agrega el producto al carrito
      this.reservaForm.detallePedido.push({
        id: null,
        cantidad: this.reservaForm.cantidad,
        producto: this.productoSeleccionado,
        cobertura: this.productoSeleccionado,
      });
      this.showModal = true;
    },
  },
  mounted() {
    this.fetchProductos();
    this.fetchCoberturas();
    console.log(this.user);
  },
};
</script>