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
                                    <button type="submit" class="btn btn-primary">
                                    <div v-if="loadingLogin" class="spinner-border spinner-border-sm" role="status">
                                        
                                    </div>
                                    {{ $t('messages.Login') }}
                                    </button>
                                </form>
                             </ValidationObserver>
                             <button type="submit" class="btn btn-primary mt-2" @click="authProvider('google')">Dang nhap bang google</button>
                             <button type="submit" class="btn btn-primary mt-2" @click="authProvider('facebook')">Dang nhap bang facebook</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { validateForm } from './validateMixin';
import { mapGetters } from 'vuex';
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
            loadingLogin:false,
            loading: true,
        }
    },
    computed: {
        ...mapGetters({
                getToken: 'auth/getToken',
                getRoles: 'auth/getRoles',
                authenticated: 'auth/authenticated',
                getPermissions: 'auth/getPermissions',
            })
    },
    mounted(){
        this.loading = false;
    },
    methods : {
        authProvider(provider) {
            let self = this;
            this.$auth.authenticate(provider).then(response => {
                self.socialLogin(provider,response)
            }).catch(err => {
                console.log({err:err})
            })
        },
        socialLogin(provider,response) {
            this.$http.post('/social/'+provider, response).then(response => {
                if(response.data.success){
                    this.$store.commit('setToken',response.data.token)
                    this.$store.commit('setUser',response.data.user)
                    this.$router.push('students');
                }
            }).catch(err => {
                this.errors = err.response.data.errors;
            })
        },
        async login(){
            try{
                this.loadingLogin = true;
                this.$store.dispatch('auth/login',this.credentials)
                    .then((data) => {
                        if(data.success){
                            this.loadingLogin = false;
                            this.$router.push({
                                name:'students'
                            }).catch(err => {
                                
                            })
                        }
                    })
                    .catch(err => {
                        this.loadingLogin = false;
                        this.$toast.error(err.response.data.message);
                    })
            }catch(error){
                console.log(error)
            }
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