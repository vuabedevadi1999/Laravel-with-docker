import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        token:localStorage.getItem('auth') || '',
        user:localStorage.getItem('user') || '',
    },
    mutations: {
        setToken(state,token){
            localStorage.setItem('auth',token);
            state.token = token;
        },
        setUser(state,user){
            localStorage.setItem('user',JSON.stringify(user));
            state.user = user;
        },
        clearToken(state){
            localStorage.removeItem('auth');
            state.token = '';
        },
        clearUser(state){
            localStorage.removeItem('user');
            state.user = '';
        }
    }
});