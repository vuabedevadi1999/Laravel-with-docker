<template>
    <div>
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="login" v-else>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">{{ $t('messages.Login') }}</div>
                        <div class="card-body">
                            <ValidationObserver v-slot="{ handleSubmit }" >
                                <form @submit.prevent="handleSubmit(login)">
                                    <ValidationProvider name="email" :rules="validationRules.ruleEmail" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">{{ $t('messages.Email') }}</label>                    
                                            <input v-model="credentials.email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('email')" class="invalid-feedback">{{ firstError('email') }}</span>
                                        </div>
                                     </ValidationProvider>
                                    <ValidationProvider name="password" :rules="validationRules.rulePassword" v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="password">{{  $t('messages.Password')  }}</label>
                                            <input v-model="credentials.password" type="password" class="form-control" id="password" placeholder="Password">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('password')" class="invalid-feedback">{{ firstError('password') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">{{ $t('messages.Login') }}</button>
                                </form>
                             </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { validateForm } from './validateMixin';
export default {
    mixins:[validateForm],
    name: "Login",
    data(){ 
        return {
            errors : null,
            credentials: {
                email: '',
                password: '',
            },
            loading: true,
        }
    },
    mounted(){
        if(this.$store.state.token != ''){
            axios.post('/api/checkToken')
                .then(response=>{
                    if(response){
                        this.loading = false;
                        this.$router.push('students');
                    }
                })
                .catch(err=>{
                    if(err.response.status == 401){
                        this.$router.push('profile');
                    }else{
                        this.loading = false;
                        this.$store.commit('clearToken');
                        this.$store.commit('clearUser');    
                    }
                })
        }else{
            this.loading = false
        }
    },
    methods : {
        login(){
            //call api
            axios.post('api/login',this.credentials)
            .then(response=>{
                if(response.data.success){
                    this.$store.commit('setToken',response.data.token)
                    this.$store.commit('setUser',response.data.user)
                    this.$router.push('students');
                }
            })
            .catch(err=>{
                this.errors = err.response.data.errors;
            })
        }
    }
}
</script>
<style scoped>
.invalid-feedback{
    display:block;
    font-size:15px;
}
</style>