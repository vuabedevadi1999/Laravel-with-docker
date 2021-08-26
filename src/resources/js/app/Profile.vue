<template>
    <div class="profile" v-cloak>
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else class="container emp-profile">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img v-if="profile.avatar && profile.avatar_type == null" class="avatar" :src="`./public/images/`+profile.avatar" alt=""/>
                            <img v-else-if="profile.avatar && profile.avatar_type == 1" class="avatar" :src="profile.avatar" alt=""/>
                            <button class="btn btn-info mt-2" @click="getProfile" data-toggle="modal" data-target="#editProfile">{{ $t('messages.Edit profile') }}</button><br>
                            <button class="btn btn-danger mt-2" @click="logout">{{ $t('messages.Logout')}}</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                            <h5>
                                {{ profile.name }}
                            </h5>
                            <h6>
                                {{ profile.job ? profile.job : 'Đang cập nhập' }}
                            </h6>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ $t('messages.Information') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ $t('messages.Edit profile') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ValidationObserver v-slot="{ handleSubmit }">
                                    <form @submit.prevent="handleSubmit(updateProfile)" enctype="multipart/form-data">
                                        <ValidationProvider name="fullname" :rules="validationRules.ruleRequired"  v-slot="{ errors }">
                                            <div class="form-group">
                                                <label for="namePrefile">{{ $t('messages.Full name') }}</label>
                                                <input v-model="profile.name" type="text" class="form-control" id="namePrefile" placeholder="Enter name">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('name')" class="invalid-feedback">{{ firstError('name') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <ValidationProvider name="avatar" :rules="validationRules.ruleImage" v-slot="{ errors,validate }">
                                            <div class="form-group">
                                                <label for="avatar">{{ $t('messages.Avatar') }}</label>
                                                <input type="file" id="file" ref="file" class="form-control" @change="validate" v-on:change="handleFileUpload()">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('file')" class="invalid-feedback">{{ firstError('file') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <ValidationProvider name="email" :rules="validationRules.ruleEmail"  v-slot="{ errors }">
                                            <div class="form-group">
                                                <label for="email">{{ $t('messages.Email') }}</label>
                                                <input v-model="profile.email" type="email" class="form-control" id="emailProfile" placeholder="Enter email">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('email')" class="invalid-feedback">{{ firstError('email') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <ValidationProvider name="password" :rules="validationRules.rulePassword"  v-slot="{ errors }">
                                            <div class="form-group">
                                                <label for="oldPassword">{{ $t('messages.Old password') }}</label>
                                                <input v-model="profile.oldPassword" type="password" class="form-control" id="oldPassword" placeholder="Enter phone">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('oldPassword')" class="invalid-feedback">{{ firstError('oldPassword') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <ValidationProvider name="password" :rules="validationRules.rulePassword" vid="profile.newPassword" v-slot="{ errors }">
                                            <div class="form-group">
                                                <label for="newPassword">{{ $t('messages.New password') }}</label>
                                                <input v-model="profile.newPassword" type="password" class="form-control" id="newPassword" placeholder="Enter phone">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('password')" class="invalid-feedback">{{ firstError('password') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <ValidationProvider name="password" :rules="validationRules.rulePasswordConfirm" vid="confirmation" v-slot="{ errors }">
                                            <div class="form-group">
                                                <label for="passwordConfirm">{{ $t('messages.Confirm Password') }}</label>
                                                <input v-model="profile.passwordConfirm" type="password" class="form-control" id="passwordConfirm" placeholder="Enter phone">
                                                <span class="invalid-feedback">{{ errors[0] }}</span>
                                                <span v-if="hasError('password_confirmation')" class="invalid-feedback">{{ firstError('password_confirmation') }}</span>
                                            </div>
                                        </ValidationProvider>
                                        <button type="submit" class="btn btn-primary">{{ $t('messages.Submit') }}</button>
                                    </form>
                                </ValidationObserver>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    <div class="col-md-8" style="margin-top: -62px;">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>ID</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ profile.id }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ $t('messages.Full name') }}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ profile.name }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>{{ $t('messages.Email') }}</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{ profile.email }}</p>
                                    </div>
                                </div>
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
    name: "Profile",
    data(){ 
        return {
            errors : null,
            loading : true,
            profile:{
                id:null,
                name:'',
                email:'',
                file: '',
                avatar:'',
                avatar_type:null,
                job:'',
                oldPassword:'',
                newPassword:'',
                passwordConfirm:''
            },
        }
    },
    mounted(){
        if(this.$store.state.token != ''){
            axios.post('/api/checkToken')
                .then(response=>{
                    if(response){
                        this.loading = false;
                        this.getProfile();
                    }
                })
                .catch(err=>{
                    if(err.response.status === 401){
                        this.loading = false;
                        this.getProfile();
                    }else{
                        this.loading = false;
                        this.$store.commit('clearToken');
                        this.$store.commit('clearUser');
                        this.$router.push('login');//chuyen sang trang login
                    }
                })
        }else{
            this.loading = false;
            this.$router.push('login');//chuyen sang trang login
        }
    },
    methods:{
        handleFileUpload(){
            this.profile.file = this.$refs.file.files[0];
        },
        getProfile(){
            axios.post('api/profile')
                .then(response=>{
                    if(response){
                        this.profile.id = response.data.user.id
                        this.profile.name = response.data.user.name
                        this.profile.avatar = response.data.user.avatar
                        this.profile.avatar_type = response.data.user.avatar_type
                        this.profile.job = response.data.user.job
                        this.profile.email = response.data.user.email
                    }
                })
                .catch(err=>{
                    this.$store.commit('clearToken');
                    this.$store.commit('clearUser');
                    this.$router.push('login')
                })
        },
        updateProfile(){
            var formData = new FormData();
            formData.append('name',this.profile.name);
            formData.append('email',this.profile.email);
            formData.append('file',this.profile.file);
            formData.append('oldPassword',this.profile.oldPassword);
            formData.append('password',this.profile.newPassword);
            formData.append('password_confirmation',this.profile.passwordConfirm);
            axios.post('api/update-profile',formData)
                .then(response=>{
                    this.loading = false;
                    this.$store.commit('clearToken');
                    this.$store.commit('clearUser');
                    this.$router.push('login');
                })
                .catch(err=>{
                    this.errors = err.response.data.errors;
                })
        },
        logout(){
            axios.post('api/logout')
                .then(response=>{
                    if(response){
                        this.$store.commit('clearToken');
                        this.$store.commit('clearUser');
                        this.$router.push('/');//chuyen sang trang login
                    }
                })
                .catch(err=>{
                    console.log("lỖI")
                })
        }
    }
}
</script>
<style scoped>
body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.avatar{
    max-width: 160px;
    max-height: 138px;
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
.invalid-feedback{
    display:block;
    font-size:15px;
}
</style>