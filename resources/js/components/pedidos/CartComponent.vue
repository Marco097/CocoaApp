<template>
  <div class="container-fluid">
      <div id="show">
          <div v-show="showDiv">
              <h4 class="text-bold text-black">Mostrar datos de la Reserva</h4>
              <div class="row">
          <div class="col">
              <label for="" class="fs-5 text-black">Cliente: </label>&nbsp;<br>{{ user.name }}
      </div>
      <div class="col">
          <label for="" class="fs-5 text-black">Fecha Reserva: </label>&nbsp;<br> {{ reservaForm.fReserva }}
      </div>
      <div class="col">
          <label for="" class="fs-5 text-black">Hora Reserva: </label>&nbsp;<br> {{ reservaForm.hora }}
      </div>
      <div class="col">
          <label for="" class="fs-5 text-black">Número de Personas: </label>&nbsp; <br>{{ reservaForm.nPersonas }}
      </div>
      </div>
      <h4>Detalle de la Reserva</h4>
      <table class="table">
          <thead>
              <tr>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Precio</th>
                  <th>Bebida</th>
              </tr>
          </thead>
          <tbody>
              <tr v-for="(item, index) in reservaForm.detalleReserva" :key="index">
                  <td>{{ item.menu.nombre }}</td>
                  <td>{{ item.menu.descripcion }}</td>
                  <td>${{ item.menu.precio }}</td>
                  <td>{{ item.menu.bebida.nombre }}</td>
                  <!--<td>{{ item.user.name }}</td>-->
                  <!--<td>{{ item.cantidad }}</td>-->
                  <!--<td>{{ item.menu.precio + this.menu.precio }}</td>-->
                  <td>
                      <button type="button" class="btn btn-danger" @click="removeItem(index)"> Eliminar
                          <i class="fa fa-trash" aria-hidden="false"></i>
                      </button>
                  </td>
              </tr> 
              <tr>
                  <td colspan="6" class="text-center"><b>Total Menu</b></td>
                  <td>${{ total }}</td>
              </tr>
              <td colspan="7" class="text-center">
                  <button type="button" class="btn btn-primary text-bg-primary" @click="saveReserva()" :disabled="reservaForm.detalleReserva.length < 1">Confirmar Reserva</button>
              </td>
                  <!--<td>${{ total }}</td>-->
          </tbody>
      </table>
          </div>
      </div>
      <div class="row">
          <div class="col-sm-4" v-for="(item, index) in menus" :key="index">
              <div class="card">
                  <img src="https://picsum.photos/300/300" class="card-img-top" alt="">
          <div class="card-body">
              <h5 class="card-title" :class="text-bold">{{ item.nombre }}&nbsp;<br><br>Descripción: {{  item.descripcion }}&nbsp;<br></h5>
              <p class="fw-bolder">Bebida: <b class="fw-light">{{  item.bebida.nombre }}</b></p>
              <p class="card-text fw-bolder">Precio: <b class="text-warning">${{ item.precio }}</b></p>
              <a href="#" class="btn btn-primary" @click="addToReserva(item)">Reservar</a>
          </div>
      </div>
  </div>
</div>
  </div>


</template>

<script>
export default {
  props:['user'],
  data() {
      return{
          reservaciones: [],
          reservaForm:{
              id:null,
              fReserva: new Date(Date.now() - new Date().getTimezoneOffset() * 60000),
              hora:new Date().getTimezoneOffset(),
              nPersonas:"",
              //cantidad: new Number("0").toFixed(2),
              user:null,
              detalleReserva:[]
          },
          cantidad:0,
          search:'',
          menus:[],
          disableButton:false,
          showDiv:false,
          //cantidad:new Number("0").toFixed(2),
      }
  },

  computed:{
      total(){
     var totalReserva = 0;
      this.reservaForm.detalleReserva.forEach((element) => {
          totalReserva += element.menu.precio;
      })
      //this.reservaForm.cantidad = totalReserva;
      return totalReserva; 
  },

  btnReservTitle(){
      return this.showDiv == false ? "ver Reserva" : "Ocultar Reserva";
  }

},
  methods: {
      async fetchMenus() {
          let me = this;
          await this.axios.get('/menus-reservas').then(response => {
              //console.log(response.data);
              me.menus = response.data;
          });
      },

      /*calcMenu(){
          const menu = new Date(this.reservaForm.fechaAlquiler);
          const fecha2 = new Date(this.reservaForm.fechaDevolucion);
          const diferenciaEnTiempo = fecha2.getTime() - fecha1.getTime();
          const diasDiferencia = diferenciaEnTiempo / (1000 * 60 * 60 *24);
          this.diasAlquiler = Math.round(diasDiferencia+1);
          //console.log(this.diasAlquiler);
      },*/
      removeItem(i){
          this.reservaForm.detalleReserva.splice(i,1);
      },
      addToReserva(item,index){
          let me = this;
          me.reservaForm.detalleReserva.push({
              
              id:null,
              cantidad:me.cantidad,
              menu:item,
              
              
              //fReserva: me.fReserva
          });
         console.log(me.reservaForm.detalleReserva);
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
            
              await this.axios.post(`/reservaciones`,me.reservaForm)
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
      this.fetchMenus();
      console.log(this.reservaForm);
  }

};
</script>

