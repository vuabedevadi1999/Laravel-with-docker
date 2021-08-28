import policies from './policies';
export default {
    install(Vue,options){
        Vue.prototype.$authorize = (policy) => {
            if(typeof policy === 'string'){ 
                return policies[policy]();
                //tuong ung voi authorize(modify,answer) hoac policies.modify(ussr,model)
            }
            
        };
    }
}