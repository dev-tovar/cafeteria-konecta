<template>
  <v-dialog
    v-if="!responde_form"
    persistent
    scrollable
    :value="true"
    v-model="dialog_product"
    max-width="500px"
  >
    <v-card>
      <v-card-title class="font-weight-bold">
        {{ title_modal }}
      </v-card-title>
      <v-card-text>
        <v-form ref="formProducto">
          <v-row wrap>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Nombre del producto</p>
              <v-text-field
                :rules="[rules_form.requerido]"
                v-model="form_producto.nombre"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Referencia</p>
              <v-text-field
                :rules="[rules_form.requerido, rules_form.alfanumerico]"
                v-model="form_producto.referencia"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Precio (Unidad)</p>
              <v-text-field
                :rules="[rules_form.requerido, rules_form.numeros]"
                v-model="form_producto.precio"
                type="number"
                min="0"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Peso</p>
              <v-text-field
                :rules="[rules_form.requerido, rules_form.numerosComas]"
                v-model="form_producto.peso"
                type="number"
                min="0"
                outlined
                dense
                suffix="lb"
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Categoría</p>
              <v-text-field
                :rules="[rules_form.requerido]"
                v-model="form_producto.categoria"
                outlined
                dense
              ></v-text-field>
            </v-col>
            <v-col sm="12" md="12" cols="12" class="py-0">
              <p class="font-weight-bold mb-1">Stock</p>
              <v-text-field
                :rules="[rules_form.requerido, rules_form.numeros]"
                v-model="form_producto.stock"
                type="number"
                min="0"
                outlined
                dense
              ></v-text-field>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
        rounded
          @click="cancelarForm"
          width="100"
          depressed
          color="primary"
          text
          class="text-capitalize"
          >Cancelar</v-btn
        >
        <v-btn
        rounded
          @click="type_form == 'new' ? insertForm() : updateForm()"
          width="100"
          depressed
          color="primary"
          class="text-capitalize"
        >
          {{ type_form == "new" ? "Guardar" : "Actualizar" }}
        </v-btn>
      </v-card-actions>
    </v-card>
    <v-snackbar
      top
      right
      color="red"
      v-model="snackbar_error"
      v-if="error_save && error_save.errors"
    >
      <ul class="ma-0">
        <template v-for="(error, key1) in error_save.errors">
          <li v-for="(item, key2) in error" :key="key1 + key2">
            {{ item }}
          </li>
        </template>
      </ul>
    </v-snackbar>
  </v-dialog>
  <v-dialog
    v-else
    v-model="responde_form"
    persistent
    scrollable
    :value="true"
    max-width="500px"
    content-class="rounded-xl"
  >
    <v-card class="rounded-xl">
      <v-card-title class="text-h5 font-weight-bold text-center d-block pt-9">
        <img
          v-if="responde_form_estado == 'ok'"
          width="130"
          src="https://cdn2.iconfinder.com/data/icons/greenline/512/check-512.png"
          alt=""
        />
        <img
          v-else
          width="130"
          src="https://cdn-icons-png.flaticon.com/512/148/148766.png"
          alt=""
        />
      </v-card-title>

      <v-card-title class="py-6 text-center d-block font-weight-bold text-h5">
        {{ responde_form_estado == "ok" ? "¡Bien Hecho!" : "!Ups¡" }}
      </v-card-title>
      <v-card-text class="text-center pb-6">
        <p class="text-center body-1" v-if="responde_form_estado == 'ok'">
          La información ha sido almacenada <br />
          con éxito
        </p>
        <p class="text-center body-1" v-else>
          No se ha podido almacenar la información, <br />
          intentalo más tarde.
        </p>
      </v-card-text>
      <v-card-actions>
        <span class="caption">Regresando...</span>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import axios from "axios";
import validaciones from "../funcionesValidar";
export default {
  mixins: [validaciones],
  data() {
    return {
      snackbar_error: false,
      error_save: null,
      loading_form_save: false,
      responde_form: false,

      dialog_product: true,
      title_modal: "",
      type_form: "new",
      form_producto: {
        id: 0,
        nombre: null,
        referencia: null,
        precio: null,
        peso: null,
        categoria: null,
        stock: null,
      },
    };
  },
  watch: {
    responde_form() {
      if (this.responde_form) {
        setTimeout(() => {
          this.cancelarForm();
        }, 2000);
      }
    },
    id_producto: {
      immediate: true,
      handler(value) {
        if (this.id_producto > 0) {
          this.getInfoProduct();
        }
      },
    },
  },
  computed: {
    id_producto() {
      return this.$route.params.id_producto
        ? this.$route.params.id_producto
        : 0;
    },
  },
  mounted() {
    if (this.$route.name) {
      this.title_modal =
        this.$route.name == "products_form_component"
          ? "Nuevo Producto"
          : "Editar Producto";
      this.type_form =
        this.$route.name == "products_form_component" ? "new" : "edit";
    }
  },
  methods: {
    insertForm() {
      //   if (this.$refs.formProducto.validate()) {
      this.loading_form_save = true;
      axios
        .post("/crudProduct", {
          form_data: this.form_producto,
        })
        .then((res) => {
          this.loading_form_save = false;
          this.responde_form = true;
          this.responde_form_estado = "ok";
        })
        .catch((err) => {
          this.snackbar_error = true;
          this.error_save = err.response.data;
          this.loading_form_save = false;
        });
      //   }
    },
    updateForm() {
      if (this.$refs.formProducto.validate()) {

        this.loading_form_save = true;
      axios
        .put("/crudProduct/" + this.id_producto,{
              form_data: this.form_producto,
        })
        .then((res) => {
          this.loading_form_save = false;
          this.responde_form = true;
          this.responde_form_estado = "ok";
        })
        .catch((err) => {
          this.snackbar_error = true;
          this.error_save = err.response.data;
          this.loading_form_save = false;
        });

      }
    },
    getInfoProduct() {
      axios
        .get("/crudProduct/" + this.id_producto)
        .then((res) => {
          if(res.data){
            this.form_producto = res.data
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    cancelarForm() {
      this.$router.go(-1);
    },
  },
};
</script>

