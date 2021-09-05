
require('./bootstrap');
import Vue from 'vue';
import App from './app/App'
import router from './app/routes';
import store from './app/store'
import i18n from './i18n';
import axios from 'axios';
import CKEditor  from "ckeditor4-vue";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import Authorization from './authorization/authorize';
import VCalendar from 'v-calendar';
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';
Vue.config.productionTip = false;
Vue.use(VCalendar, {
    componentPrefix: 'vc',
});
Vue.use(router)
Vue.use(CKEditor);
Vue.use(VueIziToast);
Vue.use(VueAxios, axios);
Vue.use(Authorization);
Vue.use(VueSocialauth, {
    providers: {
        google: {
            clientId: '814023748086-dj8s68mi8c0f3gfm3976hbb4onadtbmg.apps.googleusercontent.com',
            client_secret: 'YUKnOZklJ_3ANi737EDkDgX_',
            redirectUri: 'http://localhost:8000/callback'
        },
        facebook: {
            clientId: '330486362097117',
            client_secret: '9bd54186e91af7898b69e8e9434fd61e',
            redirectUri: 'http://localhost:8000/callback/facebook'
        }
    }
});
Vue.component('ValidationProvider',ValidationProvider);
Vue.component('ValidationObserver',ValidationObserver)
axios.interceptors.request.use((config)=>{
    let token = store.state.auth.token;
    let lang = localStorage.getItem('lang') || 'en';
    if (token) {
        config.headers['Accept'] = 'application/json';
        config.headers['Authorization'] = `Bearer ${ token }`;
        config.params = {'locate' : lang};
    }
    return config;
})
Vue.component('pagination', require('laravel-vue-pagination'));
const app = new Vue({
    el: '#app',
    i18n,
    router,
    store,
    render: app => app(App),
});