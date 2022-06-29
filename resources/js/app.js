
import Vue from 'vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

Vue.use(Vuetify);
Vue.use(VueRouter)

// window.Vue = require('vue').default;


Vue.component('home-component', require('./components/ExampleComponent.vue').default);
Vue.component('products-component', require('./components/productsComponent.vue').default);
Vue.component('products-form-component', require('./components/includes/productFormComponent.vue').default);
Vue.component('shop-products-component', require('./components/shopProductsComponent.vue').default);
Vue.component('sales-products-component', require('./components/salesProductsComponent.vue').default);
Vue.component('curriculum-component', require('./components/curriculumComponent.vue').default);

let home_component = {
    template: `<home-component></home-component>`
}
let products_component = {
    template: `<products-component></products-component>`
}
let products_form_component = {
    template: `<products-form-component></products-form-component>`
}
let shop_products_component = {
    template: `<shop-products-component></shop-products-component>`
}
let sales_products_component = {
    template: `<sales-products-component></sales-products-component>`
}
let curriculum_component = {
    template: `<curriculum-component></curriculum-component>`
}

const router = new VueRouter({
    routes: [

        {
            path: '/',
            name: 'home_component',
            component: home_component,
        },

        {
            path: '/shop-products',
            name: 'shop_products_component',
            component: shop_products_component,
        },
        {
            path: '/sales-products',
            name: 'sales_products_component',
            component: sales_products_component,
        },
        {
            path: '/yecid-tovar',
            name: 'curriculum_component',
            component: curriculum_component,
        },
        {
            path: '/products',
            name: 'products_component',
            component: products_component,
            children: [
                {
                    name: 'products_form_component',
                    path: 'new',
                    component: products_form_component,
                    props: true,
                    meta: {
                        showModal: true
                    }
                },
                {
                    name: 'edit_products_form_component',
                    path: 'edit/:id_producto',
                    component: products_form_component,
                    props: true,
                    meta: {
                        showModal: true
                    }
                },
            ]
        }
    ],
    mode: 'history'
})





const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify({
        iconfont: 'mdi',
        theme: {
            themes: {
                light: {
                    primary: '#002855', // azul
                    secondary: '#0072ce', // amarillo
                    accent: '#ffc72c', // amarillo
                }
            }
        },
    }),
    data() {
        return {
            drawer: true,
            items_menu: [
                { title: 'Inicio', icon: 'mdi-home', url: "/" },
                { title: 'Productos', icon: 'mdi-view-dashboard-outline', url: "/products" },
                { title: 'Venta de Productos', icon: 'mdi-cart', url: "/shop-products" },
                { title: 'Ventas Realizadas', icon: 'mdi-cart-arrow-right', url: "/sales-products" },
            ],
        }
    },
});