<template>
  <div>
    <v-card color="transparent" elevation="0">
      <v-card-title class="pb-0 font-weight-bold primary--text">
        <v-avatar color="primary" class="mr-3">
          <v-icon dark> mdi-cart-arrow-right </v-icon>
        </v-avatar>
        Ventas Realizadas
      </v-card-title>
      
      <v-card-text>
        <v-row wrap>
          <v-col sm="12" md="12" cols="12">
            <v-data-table
              :headers="headers"
              :items="desserts"
              class="elevation-1"
              :footer-props="{
                'items-per-page-text': 'Filas por página',
                pageText: '{0}-{1} de {2}',
              }"
            >
              
            </v-data-table>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      headers: [
        {
          text: "Número de Referencia",
          align: "start",
          sortable: false,
          value: "numero_referencia",
        },
        { text: "Valor Total", value: "total" },
        { text: "Productos por referencia", value: "productos_count" },
        { text: "Fecha de la venta", value: "created_at" },
        { text: "", value: "actions" },
      ],
      desserts: [],
    };
  },

  mounted() {
    this.getSalesProducts();
  },
  methods: {
    getSalesProducts(){
      axios.get('/crudSale')
      .then(res => {
        this.desserts = res.data
      })
      .catch(err => {
        console.error(err); 
      })
    }
  },
};
</script>
