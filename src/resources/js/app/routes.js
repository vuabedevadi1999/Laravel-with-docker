import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
Vue.use(VueRouter);
const router = new VueRouter({
    mode : 'history',
    routes : [
        {
            path: '/',
            name: 'home',
            component : require('./Home').default,
        },
        {
            path: '/login',
            name: 'login',
            component : require('./Login').default,
        },
        {
            path: '/students',
            name: 'students',
            component : require('./StudentList').default,
            meta: {
                requiredRoles: ['admin', 'manager', 'editor']
            },
            // beforeEnter: async (to, from, next) => {
            //     let roles = store.getters["auth/getRole"];
            //     let hasRole = false;
            //     hasRole = roles.some(role => to.meta.requiredRoles.includes(role))
            //     if(hasRole){
            //         next();
            //     }else{
            //         next({name:'profile'})
            //     }
            // }
        },
        {
            path: '/students/:id',
            name: 'students-detail',
            component : require('./StudentDetail').default,
            meta: {
                requiredRoles: ['admin', 'manager', 'editor']
            },
        },
        {
            path: '/profile',
            name: 'profile',
            component : require('./Profile').default,
        },
    ]
});
router.beforeEach((to, from, next) => {
    const { requiredRoles } = to.meta;
    const authenticated = store.getters["auth/authenticated"];
    const roles = store.getters["auth/getRoles"];
    if (!authenticated && to.path !== '/login') {
        return next({ path: '/login' });
    }else{
        if (requiredRoles) {
            let hasRole = roles.some(role => to.meta.requiredRoles.includes(role))
            if (requiredRoles.length && !hasRole) {
                return next({ path: '/profile' });
            }else{
                next();
            }
        }else{
            if (authenticated && to.path === '/login') {
                return next({path: '/profile'})
            }
            next()
        }
    }
});
export default router