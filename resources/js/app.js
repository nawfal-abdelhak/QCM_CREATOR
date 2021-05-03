/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueSweetalert2 from 'vue-sweetalert2';
import VueRouter from 'vue-router';
import VeeValidate, { Validator } from 'vee-validate';
import fr from 'vee-validate/dist/locale/fr';
import 'sweetalert2/dist/sweetalert2.min.css';
import { VclBulletList, VclList } from 'vue-content-loading';
import helpers from './helpers';

Vue.use(VueSweetalert2);
Vue.use(VueRouter);

// Vue.use(VeeValidate, {
//   classes: true,
//   classNames: {
//     valid: 'is-valid',
//     invalid: 'is-invalid'
//   }
// });
// Validator.localize('fr', fr);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('notifications-component', require('./components/NotificationsComponent.vue').default);

// import components for router
import Home from './components/HomeComponent';
import Example from './components/ExampleComponent';
import Qcm from './components/qcmcomponent';
import MyQcm from './components/myqcmComponent';
import NotFound from './components/NotFoundComponent';
import Addstudent from './components/addstudent';
import test from './components/test';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import VueDraggableResizable from 'vue-draggable-resizable'
 
// optionally import default styles
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'


Vue.use(BootstrapVue)
Vue.component('vue-draggable-resizable', VueDraggableResizable)

Vue.component('vcl-bullet-list', VclBulletList);
Vue.component('vcl-list', VclList);

const router = new VueRouter({
    mode: 'history',
    base: 'pfe-project/public',
    routes: [
        // {
        //     path: '/',
        //     name: 'home',
        //     component: Home
        // },


        // {
        //     path: '/test',
        //     name: 'test',
        //     component: test,
            
        // },
        
        { path: '/', 
        redirect: '/createQcm' },
        {
            path: '/createQcm',
            name: 'createQcm',
            component: Example,
            beforeEnter: (to, from, next) => {
                if (Laravel.user.is_admin) next()
                else next("Qcm")
            }
        },
        {
            path: '/qcm',
            name: 'qcm',
            component: Qcm,
            beforeEnter: (to, from, next) => {
                if (!Laravel.user.is_admin) next()
                else next("NotFound")
            }
        },
        {
            path: '/myqcm',
            name: 'myqcm',
            component: MyQcm,
            beforeEnter: (to, from, next) => {
                if (Laravel.user.is_admin) next()
                else next("NotFound")
            }
            
        },
        {
            path: '/addstudent',
            name: 'addstudent',
            component: Addstudent,
            beforeEnter: (to, from, next) => {
                if (Laravel.user.is_admin) next()
                else next("NotFound")
            }
        },
        { path: "*", component: NotFound }
    ],
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin(helpers());

const app = new Vue({
    el: '#app',
    router,
    methods: {
        subIsActive(input) {
            const paths = Array.isArray(input) ? input : [input]
            return paths.some(path => {
                return this.$route.path === path
            })
        }
    }
});
