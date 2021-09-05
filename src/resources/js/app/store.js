import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);
import  auth  from './authModule.js';
const store = new Vuex.Store({
    modules: {
        auth
    },
});
export default store;