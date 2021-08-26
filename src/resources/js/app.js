
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
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'
Vue.use(CKEditor);
Vue.use(VueAxios, axios);
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: '814023748086-dj8s68mi8c0f3gfm3976hbb4onadtbmg.apps.googleusercontent.com',
            client_secret: 'YUKnOZklJ_3ANi737EDkDgX_',
            redirectUri: 'http://localhost:8000/callback'
        }
    }
});
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