<template>
  <div>
    <v-card color="transparent" elevation="0">
      <v-card-title class="pb-0 font-weight-bold primary--text">
        <v-avatar color="primary" class="mr-3">
          <v-icon dark> mdi-view-dashboard-outline </v-icon>
        </v-avatar>
        Productos
      </v-card-title>
      <v-card-title class="pb-0 font-weight-bold primary--text">
        <v-spacer></v-spacer>
        <v-btn
        rounded
          @click="openDialoProduct('new')"
          color="primary"
          dark
          class="mb-2 text-capitalize"
          depressed
          to="/products/new"
        >
          <v-icon left>mdi-plus</v-icon> Agregar Nuevo Producto
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-row wrap>
          <v-col sm="12" md="12" cols="12">
            <v-data-table
              :loading="load_data"
              :headers="headers"
              :items="desserts"
              class="elevation-1"
              :footer-props="{
                'items-per-page-text': 'Filas por página',
                pageText: '{0}-{1} de {2}',
              }"
            >
              <template v-slot:item.actions="{ item }">
                <div>
                  <v-tooltip top color="red">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        @click="deleteProductConfirm(item.id)"
                        icon
                        v-bind="attrs"
                        v-on="on"
                      >
                        <v-icon color="red"> mdi-delete </v-icon>
                      </v-btn>
                    </template>
                    <span>Eliminar</span>
                  </v-tooltip>

                  <v-tooltip top color="primary">
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        :to="'/products/edit/' + item.id"
                        icon
                        v-bind="attrs"
                        v-on="on"
                      >
                        <v-icon color="primary"> mdi-pencil </v-icon>
                      </v-btn>
                    </template>
                    <span>Editar</span>
                  </v-tooltip>
                </div>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
    <router-view></router-view>

    <v-dialog
      v-model="dialog_delete_product"
      persistent
      scrollable
      max-width="500px"
      content-class="rounded-xl"
    >
      <v-card class="rounded-xl">
        <v-card-title class="text-h5 font-weight-bold text-center d-block pt-9">
          <img
            width="130"
            src="https://d1nhio0ox7pgb.cloudfront.net/_img/g_collection_png/standard/512x512/question.png"
            alt=""
          />
        </v-card-title>

        <v-card-title class="py-6 text-center d-block font-weight-bold text-h5">
          Estas a punto de eliminar este producto
        </v-card-title>
        <v-card-text class="text-center pb-6">
          <p class="text-center body-1">
            Una vez eliminado no se podra visualizar en el sistema, <br />
            ¿Desea continuar con la eliminación?
          </p>
        </v-card-text>
        <v-card-actions class="text-center d-block">
          <v-btn
          rounded
            @click="cancelDelete"
            depressed
            class="text-capitalize"
            width="100"
            text
            color="primary"
            >Cancelar</v-btn
          >
          <v-btn
          rounded
            @click="deleteProduct"
            depressed
            dark
            class="text-capitalize"
            width="100"
            color="red"
            >Si, eliminar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      id_product_delete: 0,
      dialog_delete_product: false,
      dialog_product: false,
      load_data: false,
      type_form: "new",
      headers: [
        {
          text: "Nombre del Producto",
          align: "start",
          sortable: false,
          value: "nombre",
        },
        { text: "Stock", value: "stock" },
        { text: "Referencia", value: "referencia" },
        { text: "Categoría", value: "categoria" },
        { text: "Peso (Lb)", value: "peso" },
        { text: "Precio", value: "precio" },
        { text: "Fecha de creación", value: "created_at" },
        { text: "", value: "actions" },
      ],
      desserts: [],
    };
  },
  watch: {
    $route(to, from) {
      if (
        to.name &&
        to.name == "products_component" &&
        from.name &&
        (from.name == "products_form_component" ||
          from.name == "edit_products_form_component")
      ) {
        this.getProducts();
      }
    },
  },
  mounted() {
    this.getProducts();
  },
  methods: {
    cancelDelete() {
      this.id_product_delete = 0;
      this.dialog_delete_product = false;
    },
    deleteProductConfirm(id) {
      this.id_product_delete = id;
      this.dialog_delete_product = true;
    },
    getProducts() {
      this.load_data = true;
      axios
        .get("/crudProduct")
        .then((res) => {
          this.desserts = res.data;
          this.load_data = false;
          //   console.log(res);
        })
        .catch((err) => {
          this.load_data = false;
          console.error(err);
        });
    },
    deleteProduct() {
      axios
        .delete("/crudProduct/" + this.id_product_delete)
        .then((res) => {
          this.id_product_delete = 0;
          this.dialog_delete_product = false;
          this.getProducts();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    openDialoProduct(type) {
      this.type_form = type;
    },
  },
};
</script>
