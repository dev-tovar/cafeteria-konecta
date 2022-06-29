<template>
  <div>
    <v-card color="transparent" elevation="0">
      <v-card-title class="pb-0 font-weight-bold primary--text">
        <v-avatar color="primary" class="mr-3">
          <v-icon dark> mdi-cart </v-icon>
        </v-avatar>
        Venta de Productos
      </v-card-title>
      <v-card-title class="pb-0 font-weight-bold primary--text">
        <v-spacer></v-spacer>
      </v-card-title>
      <v-card-text>
        <v-row wrap>
          <v-col sm="12" md="7" cols="12">
            <v-card color="transparent" elevation="0">
              <v-card-title>
                <h3>Buscar los productos que deseas añadir a la venta</h3>
                <p class="body-1">
                  Puedes añadir más de un producto a la compra
                </p>
              </v-card-title>
              <v-card-text>
                <v-text-field
                  solo
                  rounded
                  placeholder="Busqueda de productos por nombre o referencia"
                  append-icon="mdi-magnify"
                  v-model="search_product"
                  @click:append="buscarProducto"
                  hint="Para buscar solo basta con presionar enter"
                  v-on:keyup.enter="buscarProducto"
                >
                </v-text-field>
                <v-list-item>
                  <v-list-item-content> </v-list-item-content>
                  <v-list-item-action>
                    <v-btn
                      @click="agregarProducto"
                      :disabled="add_products.length > 0 ? false : true"
                      depressed
                      rounded
                      color="primary"
                      class="text-capitalize"
                    >
                      Añadir Producto(s) <b> +{{ add_products.length }}</b>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item>
                <v-list
                  class="rounded-lg py-0"
                  v-if="productos_encontrados.length > 0"
                >
                  <template v-for="(item, i) in productos_encontrados">
                    <div :key="`item-${i}`">
                      <v-divider class="my-0" v-if="i > 0"></v-divider>
                      <v-list-item active-class="select-product-shop">
                        <v-list-item-content>
                          <v-list-item-title>
                            <span class="font-weight-bold">Nombre :</span>
                            {{ item.nombre }}
                          </v-list-item-title>
                          <v-list-item-title>
                            <span class="font-weight-bold">Referencia :</span>
                            {{ item.referencia }}
                          </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-content>
                          <v-list-item-title>
                            <span class="font-weight-bold">Stock :</span>
                            {{ item.stock }}
                          </v-list-item-title>
                          <v-list-item-title>
                            <span class="font-weight-bold">Precio :</span>
                            {{ item.precio }}
                          </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-content style="max-width: 150px">
                          <v-list-item-title>
                            <v-text-field
                              v-model="item.cantidad"
                              filled
                              type="number"
                              min="1"
                              :max="item.stock"
                              rounded
                              dense
                              hide-details
                              @keyup="
                                validarStock(
                                  i,
                                  item.cantidad,
                                  item.stock,
                                  item.precio
                                )
                              "
                            ></v-text-field>
                          </v-list-item-title>
                        </v-list-item-content>

                        <v-list-item-action>
                          <v-checkbox
                            multiple
                            v-model="add_products"
                            :value="item"
                            color="accent"
                          ></v-checkbox>
                        </v-list-item-action>
                      </v-list-item>
                    </div>
                  </template>
                </v-list>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col sm="12" md="5" cols="12">
            <v-card
              class="rounded-lg"
              min-height="250"
              v-if="mis_productos.length > 0"
            >
              <v-card-title>
                <h3>Listado de productos añadidos</h3>
              </v-card-title>
              <v-card-text>
                <v-list class="rounded-lg py-0">
                  <template v-for="(itemadd, i) in mis_productos">
                    <div :key="`add-${i}`">
                      <v-divider class="my-0" v-if="i > 0"></v-divider>
                      <v-list-item active-class="select-product-shop">
                        <v-list-item-content>
                          <v-list-item-title>
                            <span class="font-weight-bold">Nombre :</span>
                            {{ itemadd.nombre }}
                          </v-list-item-title>
                          <v-list-item-title>
                            <span class="font-weight-bold">Referencia :</span>
                            {{ itemadd.referencia }}
                          </v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-content>
                          <v-list-item-title>
                            <span class="font-weight-bold">Cantidad :</span>
                            <!-- {{ itemadd.cantidad }} -->
                            <input
                              class="custom-input-cantidad"
                              type="number"
                              min="1"
                              :max="itemadd.stock"
                              name="cantidad"
                              v-model="itemadd.cantidad"
                              @input="refrestTotal"
                              @keyup="
                                validarStockAdd(
                                  i,
                                  itemadd.cantidad,
                                  itemadd.stock,
                                  itemadd.precio
                                )
                              "
                            />
                          </v-list-item-title>
                          <v-list-item-title>
                            <span class="font-weight-bold">Precio :</span>
                            {{ itemadd.precio }}
                          </v-list-item-title>
                        </v-list-item-content>

                        <v-list-item-action style="min-width: 58px">
                          <v-list-item-title class="h4">
                            <v-tooltip top color="red">
                              <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                  @click="deleteProduct(i)"
                                  icon
                                  v-bind="attrs"
                                  v-on="on"
                                >
                                  <v-icon color="red"> mdi-delete </v-icon>
                                </v-btn>
                              </template>
                              <span>Eliminar</span>
                            </v-tooltip>
                          </v-list-item-title>
                        </v-list-item-action>
                        <v-list-item-action style="min-width: 58px">
                          <v-list-item-title class="h4 text-right">
                            {{ itemadd.subtotal }}
                          </v-list-item-title>
                        </v-list-item-action>
                      </v-list-item>
                    </div>
                  </template>

                  <v-divider class="my-0"></v-divider>
                  <v-list-item active-class="select-product-shop">
                    <v-list-item-content> </v-list-item-content>
                    <v-list-item-content> </v-list-item-content>

                    <v-list-item-action>
                      <v-list-item-title>
                        <span class="font-weight-bold h3">Total:</span>
                        <span class="font-weight-bold h4">{{
                          total_compra
                        }}</span>
                      </v-list-item-title>
                    </v-list-item-action>
                  </v-list-item>
                </v-list>
              </v-card-text>
              <v-card-actions class="text-center d-block">
                <v-btn
                  @click="guardarVenta"
                  min-width="200"
                  class="font-weight-bold"
                  depressed
                  rounded
                  color="secondary"
                  >Confirmar Compra</v-btn
                >
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
    <v-snackbar
      top
      right
      color="red"
      v-model="snackbar_error_stock"
      v-if="error_save && error_save.status == 'error_stock'"
    >
      <h5 class="font-weight-bold">
        El Stock para algunos productos ha cambiado:
      </h5>
      <ul class="ma-0">
        <template v-for="(error, key1) in error_save.products">
          <li :key="key1">{{ error.nombre }} {{ error.stock }} en stock</li>
        </template>
      </ul>
    </v-snackbar>
    <v-dialog
      v-model="venta_ok_dialog"
      persistent
      scrollable
      max-width="500px"
      content-class="rounded-xl"
    >
      <v-card class="rounded-xl">
        <v-card-title class="text-h5 font-weight-bold text-center d-block pt-9">
          <img
            width="130"
            src="https://cdn2.iconfinder.com/data/icons/greenline/512/check-512.png"
            alt=""
          />
        </v-card-title>

        <v-card-title class="py-6 text-center d-block font-weight-bold text-h5">
          ¡Bien Hecho!
        </v-card-title>
        <v-card-text class="text-center pb-6">
          <p class="text-center body-1">
            La venta se ha procesado correctamente, <br />
            Puede consultar el detalle en el módulo de ventas realizadas.
          </p>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      venta_ok_dialog: false,
      snackbar_error_stock: false,
      error_save: null,
      search_product: null,
      loading_search: false,
      productos_encontrados: [],
      add_products: [],
      mis_productos: [],
      total_compra: 0,
    };
  },
  watch: {
    venta_ok_dialog() {
      if (this.venta_ok_dialog) {
        setTimeout(() => {
          this.venta_ok_dialog = false;
          Object.assign(this.$data, this.$options.data());
        }, 2000);
      }
    },
  },
  mounted() {},
  methods: {
    guardarVenta() {
      axios
        .post("/crudSale", {
          form_data: this.mis_productos,
          total_compra: this.total_compra,
        })
        .then((res) => {
          this.venta_ok_dialog = true;

          console.log(res);
        })
        .catch((err) => {
          this.snackbar_error_stock = true;
          this.error_save = err.response.data;
          // console.error(err);
        });
    },
    buscarProducto() {
      if (this.search_product) {
        this.loading_search = true;
        this.add_products = [];
        axios
          .post("/search-product", {
            search: this.search_product,
          })
          .then((res) => {
            this.loading_search = false;
            this.productos_encontrados = res.data;
            console.log(res);
          })
          .catch((err) => {
            this.loading_search = false;
            console.error(err);
          });
      }
    },
    validarStock(index, cantidad, stock) {
      if (cantidad > stock) {
        this.productos_encontrados[index]["cantidad"] = stock;
      }
    },
    validarStockAdd(index, cantidad, stock) {
      if (cantidad > stock) {
        this.mis_productos[index]["cantidad"] = stock;
      }
    },
    deleteProduct(index) {
      this.mis_productos.splice(index, 1);
      this.refrestTotal();
    },
    refrestTotal() {
      setTimeout(() => {
        this.mis_productos.forEach((product) => {
          product.subtotal =
            parseInt(product.cantidad) * parseInt(product.precio);
        });
        var totalCompra = this.mis_productos.reduce(
          (sum, value) =>
            typeof value.subtotal == "number" ? sum + value.subtotal : sum,
          0
        );

        this.total_compra = totalCompra;
      }, 500);
    },
    agregarProducto() {
      //recorremos cada uno de los preductos que se van a agregar

      this.add_products.forEach((productoadd) => {
        var prod = JSON.parse(JSON.stringify(productoadd));
        //VERIFICAMOS SI YA ESTA AÑADIDO
        var verifi = this.mis_productos.find(
          (miproducto) => miproducto.id == prod.id
        );
        //SI YA ESTA, ACTUALIZAMOS LA CANTIDAD
        if (verifi) {
          verifi.cantidad = parseInt(verifi.cantidad) + parseInt(prod.cantidad);

          if (parseInt(verifi.cantidad) > parseInt(verifi.stock)) {
            verifi.cantidad = parseInt(verifi.stock);
          }

          verifi["subtotal"] =
            parseInt(verifi.cantidad) * parseInt(verifi.precio);
        } else {
          prod["subtotal"] = parseInt(prod.cantidad) * parseInt(prod.precio);

          this.mis_productos.push(prod);
        }
      });

      var totalCompra = this.mis_productos.reduce(
        (sum, value) =>
          typeof value.subtotal == "number" ? sum + value.subtotal : sum,
        0
      );
      this.total_compra = totalCompra;

      this.add_products = [];
    },
  },
};
</script>
<style>
.select-product-shop::before {
  opacity: 0 !important;
}
.custom-input-cantidad {
  border: 1px solid #999;
  width: 82px;
  border-radius: 6px;
  padding: 2px 5px;
  background: #f0f0f0;
}
</style>
