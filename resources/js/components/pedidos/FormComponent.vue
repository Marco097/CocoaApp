<template>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col">
          <label for="">Direccion de envio</label>
          <input type="text" v-model="reservaForm.direccionEnvio" class="form-control" />
        </div>
        <div class="col">
          <label for="">Numero de Telefono</label>
          <input type="text" v-model="reservaForm.telefono" class="form-control" />
        </div>
        <div class="col">
          <button class="btn btn-outline-primary" @click="showDiv = !showDiv">
            {{ btnReservTitle }}
          </button>
        </div>
        <br>
        <div id="show">
          <div v-show="showDiv">
            <div class="row">
              <div class="col">
                <label for="">Cliente</label> &nbsp;{{ user.name }}
              </div>
            </div>
            <h4>Carrito</h4>
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>sabor</th>
                  <th>relleno</th>
                  <th>descripcion</th>
                  <th>unidades</th>
                  <th>SubTotal</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in reservaForm.detallePedido" :key="index">
                  <td>{{ item.producto.nombre }}</td>
                  <!--<td>{{ item.producto.sabor.nombre }}</td>-->
                  <td>{{ item.producto.relleno.nombre }}</td>
                  <td>{{ item.producto.descripcion }}</td>
                  <td>{{ item.producto.precio }}</td>
                  <td>{{ item.subTotal }}</td>
                  <td>
                    <button type="button" class="btn btn-danger btn-sm" @click="removeItem(index)">
                      <i class="fa fa-trash" aria-hidden="false"></i>
                    </button>
                  </td>
                </tr>
                <tr>
                  <td colspan="6" class="text-center">
                    <b>Total Pedido</b>
                  </td>
                  <td>{{ total }}</td>
                </tr>
                <tr>
                  <td colspan="7" class="text-center">
                    <button type="button" class="btn btn-primary" @click="saveReserva()" :disabled="reservaForm.detallePedido.length < 1">
                      Confirmar Pedido
                    </button>
                  </td>
                  <td>{{ total }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4" v-for="(item, index) in productos" :key="index">
            <div class="card">
              <img :src="`/imagenes/productos/${item.imagen}`" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title text-bold">{{ item.nombre }}&nbsp;{{ item.relleno.nombre }}&nbsp;{{ item.anio }}</h5>
                <p class="card-text">Precio total <b class="text-warning">${{ item.precio }}</b></p>
                <a href="#" class="btn btn-primary" @click="addToReserva(item)">Agregar al carrito</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </template>
  
  <script>
  export default {
    props: ["user"],
    data() {
      return {
        productos: [],
        reservaForm: {
          id: null,
          direccionEnvio: "",
          telefono: "",
          costoEnvio: "",
          //fecha: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
          estado: "R",
          total: new Number("0").toFixed(2),
          user: null,
          detallePedido: [],

        },
        search: "",
        //sabores: [],
        rellenos: [],
        //indexProducto: -1,
        disableButton: false,
        showDiv: false,
      }
    },
    computed: {
      total() {
        var totalPedido = 0;
        this.reservaForm.detallePedido.forEach((element) => {
          totalPedido += element.total;
        });
        this.reservaForm.total = totalPedido;
        return totalPedido;
      },
      btnReservTitle() {
        return this.showDiv == false ? "Ver Reserva" : "Ocultar Reserva";
      },
    },
  
    methods: {
      async fetchProductos() {
        let me = this;
        await this.axios.get("/productos-reservas").then((response) => {
          console.log(response.data);
          me.productos = response.data;
        });
      },
      showDialog() {
        $("#reservaModal").modal("show");
      },
      removeItem(i) {
        this.reservaForm.detallePedido.splice(i, 1);
      },
      addToReserva(item) {
        let me = this;
        me.reservaForm.detallePedido.push({
          id: null,
          producto: item,
          subTotal: item.producto.precio,
        });
      },
      async saveReserva() {
        let me = this;
        if (me.reservaForm.fecha.length > 0 && me.reservaForm.detallePedido.length > 0) {
          //seteando datos faltantes para la renta
          me.reservaForm.user = this.user;
         // var f = new Date();
          //me.reservaForm.fechaReserva = f.getFullYear() + "-" + f.getMonth() + "-" + f.getDate();
          await this.axios.post(`/pedidos`, me.reservaForm)
            .then(response => {
              if (response.status == 201) {
                this.$swal.fire("success", "Su reserva se a registrado con exito, pronto nos comunicaremos");
                me.reservaForm.detallePedido = [];
                me.showDiv = false;
              }
            }).catch(errors => {
              console.log(errors);
            })
        } else {
          this.$swal.fire("warnig", "Complete los datos de la reserva");
        }
      },
    },
    mounted() {
      // this.$swal('Welcome to RentasCars!!!');
      this.fetchProductos();
      //this.fetchMarcas();
      //this.fetchModelos();
      console.log(this.user);
    },
  };
  </script>
  