export default {
    checkRole(){
        return axios.post('/api/getRole')
            .then(res => {
                let roles =  res.data.roles;
                if(roles.includes('Admin')){
                    return true;
                }else{
                    return false;
                }
            })
            .catch(err => {
                return false;

            })
    }
}