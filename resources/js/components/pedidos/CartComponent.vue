<template>
    <div id="show">
      <div v-show="showDiv">
        <h4 class="text-bold text-black">Mostrar datos de la Reserva</h4>
        <h4>Detalle de la Reserva</h4>
        <table class="table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Descripcion</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in reservaForm.detallePedido" :key="index">
              <td>{{ item.producto.nombre }}</td>
              <td>{{ item.producto.descripcion }}</td>
              <td>${{ item.producto.precio }}</td>
              <td>
                <button type="button" class="btn btn-danger" @click="removeItem(index)">Eliminar
                  <i class="fa fa-trash" aria-hidden="false"></i>
                </button>
              </td>
            </tr>
            <tr>
              <td colspan="3" class="text-center"><b>Total</b></td>
              <td>${{ total }}</td>
            </tr>
            <tr>
              <td colspan="4" class="text-center">
                <button
                  type="button"
                  class="btn btn-primary text-bg-primary"
                  @click="saveReserva()"
                  :disabled="reservaForm.detallePedido.length < 1"
                >
                  Confirmar Reserva
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['user'],
    data() {
      return {
        reservaForm: {
          id: null,
          user: null,
          detallePedido: [],
        },
        showDiv: false,
      };
    },
  
    computed: {
      total() {
        var totalReserva = 0;
        this.reservaForm.detallePedido.forEach((element) => {
          totalReserva += element.producto.precio;
        });
        return totalReserva;
      },
    },
  
    methods: {
        async fetchProductos() {
      let me = this;
      await this.axios.get("/productos-cart").then((response) => {
        console.log(response.data);
        me.productos = response.data.map((item) => ({
          ...item,
          cantidad: 0,
        }));
      });
    },
      removeItem(index) {
        this.reservaForm.detallePedido.splice(index, 1);
      },
      async saveReserva(){
            let me = this;
            if(me.reservaForm.fReserva.length > 0 && me.reservaForm.detalleReserva.length > 0){
                //seteando datos faltantes para la reserva
                me.reservaForm.user = this.user;
                var f = new Date();
                me.reservaForm.fReserva = f.getFullYear()+"-" + f.getMonth()+"-"+ f.getDate();
                //me.reservaForm.cantidad = me.reservaForm.detalleReserva.length;
                
                me.reservaForm.cantidad = me.reservaForm.detalleReserva.length;
              
                await this.axios.post(`/pedidos`,me.reservaForm)
                .then(response =>{
                    if(response.status == 201){
                        this.$swal.fire("success", "Su reserva se ha registrado con exito, Pronto nos comunicaremos");
                        me.reservaForm.detalleReserva = [];
                        me.showDiv = false;
                    }
                }).catch(errors =>{
                    console.log(errors);
                })
         }else{
            this.$swal.fire("warning", "Complete los datos de la reserva");
         }
      }, 
    },
  
    mounted() {
        this.fetchProductos();
        console.log(this.reservaForm);
    },
  };
  </script>
  