import policies from './policies';
export default {
    install(Vue,options){
        Vue.prototype.$authorize = (policy,roles) => {
            if(typeof policy === 'string'){ 
                return policies[policy](roles);
                //tuong ung voi authorize(modify,answer) hoac policies.modify(ussr,model)
            }
            
        };
    }
}