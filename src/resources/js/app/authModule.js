import { isLogged, setLogged, removeToken } from '../utils/auth.js';
const state =  {
    token: isLogged(),
    user: null,
    roles: [],
    permissions: [],
};
const getters = {
    getToken: state => state.token,
    getUser: state => state.user,
    getRoles: state => state.roles,
    getPermissions: state => state.permissions,
    authenticated(state) {
        return state.token;
    },
};
const mutations = {
    SET_TOKEN(state,token){
        state.token = token;
        //localStorage.setItem('auth',token);
    },
    SET_USER(state,user){
        state.user = user;
        //localStorage.setItem('user',JSON.stringify(user));
    },
    SET_PERMISSIONS(state,permissions){
        state.permissions = permissions;
    },
    SET_ROLES(state,roles){
        state.roles = roles;
    },
    CLEAR_TOKEN(state){
        state.token = null;
        //localStorage.removeItem('auth');
    },
    CLEAR_USER(state){
        state.user = null;
        //localStorage.removeItem('user');
    },
    CLEAR_ROLES(state){
        state.roles = [];
    },
    CLEAR_PERMISSIONS(state){
        state.permissions = [];
    }
};
const actions = {
    async login({ dispatch }, credentials){
        let response =  await axios.post('api/login',credentials)
        if(response.data.success){
            await dispatch('attempt', response.data);
        }
        return response.data; 
    },
    async attempt({ commit }, data){
        commit('SET_TOKEN', data.token);
        setLogged(data.token);
        // commit('SET_USER', data.user);
        // commit('SET_ROLES', data.roles);
        // commit('SET_PERMISSIONS', data.permissions);
        try {
            let res = await axios.post('api/profile');
            commit('SET_USER', res.data.user);
            commit('SET_ROLES', res.data.roles);
            commit('SET_PERMISSIONS', res.data.permissions);
        } catch (error) {
            commit('CLEAR_USER');
            commit('CLEAR_ROLES');
            commit('CLEAR_PERMISSIONS');
        }
    },
    async userInfo({ commit }){
        try {
            let res = await axios.post('api/profile');
            console.log(res);
            if(res.data.success){
                commit('SET_USER', res.data.user);
                commit('SET_ROLES', res.data.roles);
                commit('SET_PERMISSIONS', res.data.permissions);
            }
            return res.data;
        } catch (error) {
            commit('CLEAR_USER');
            commit('CLEAR_ROLES');
            commit('CLEAR_PERMISSIONS');
        }
    }
    ,
    async logout({ commit }){
        try {
            let res = await axios.post('api/logout');
            commit('CLEAR_TOKEN');
            commit('CLEAR_USER');
            commit('CLEAR_ROLES');
            commit('CLEAR_PERMISSIONS');
            removeToken();
        } catch (error) {
            commit('CLEAR_TOKEN');
            commit('CLEAR_USER');
            commit('CLEAR_ROLES');
            commit('CLEAR_PERMISSIONS');
        }
    },
    async clearTokenAndUser({ commit }){
        commit('CLEAR_TOKEN');
        commit('CLEAR_USER');
        commit('CLEAR_ROLES');
        commit('CLEAR_PERMISSIONS');
        removeToken();
    }
};
export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};