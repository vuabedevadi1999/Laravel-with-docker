
require('./bootstrap');
import Vue from 'vue';
import App from './app/App'
import { routes } from './app/routes';
import VueRouter from 'vue-router';
import { store } from './app/store'
import i18n from './i18n';
import axios from 'axios';
import CKEditor  from "ckeditor4-vue";
import { ValidationProvider, ValidationObserver } from "vee-validate";
Vue.config.productionTip = false;
Vue.use(CKEditor);
Vue.component('ValidationProvider',ValidationProvider);
Vue.component('ValidationObserver',ValidationObserver)
axios.interceptors.request.use((config)=>{
    let token = store.state.token;
    let lang = localStorage.getItem('lang') || 'en';
    if (token) {
        config.headers['Accept'] = 'application/json';
        config.headers['Authorization'] = `Bearer ${ token }`;
        config.params = {'locate' : lang};
    }
    return config;
})
Vue.component('pagination', require('laravel-vue-pagination'));
const router = new VueRouter({
    routes,
    mode : 'history',
});

const app = new Vue({
    el: '#app',
    i18n,
    router: router,
    store: store,
    render: app => app(App),
});