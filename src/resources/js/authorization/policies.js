export default {
    isLogged(){
        
    },
    isRole(roles){
        if(roles){
            if(roles.includes('admin') || roles.includes('editor') || roles.includes('manager')){
                return true;
            }else return false;
        }
        return false;
    },
}