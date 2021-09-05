<template>
    <div class="students">
        <div v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div v-else>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createStudent">
            {{ $t('messages.Create a new student') }}
            </button>
            <button class="btn btn-outline-primary" 
            v-on:click="$toast.success('Welcome!', 'Hey')">Show</button>&nbsp;
            <!-- Modal create student-->
            <div class="modal fade" data-focus="false" id="createStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ $t('messages.Create a new student') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(saveStudent)">
                                    <ValidationProvider name="fullname" :rules="validationRules.ruleRequired"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="name">{{ $t('messages.Full name') }}</label>
                                            <input v-model="student.name" type="text" class="form-control" id="name" placeholder="Enter name">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('name')" class="invalid-feedback">{{ firstError('name') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" :rules="validationRules.ruleEmail"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">{{ $t('messages.Email') }}</label>
                                            <input v-model="student.email" type="email" class="form-control" id="email" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('email')" class="invalid-feedback">{{ firstError('email') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="phone" :rules="validationRules.rulePhone"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="phone">{{ $t('messages.Phone') }}</label>
                                            <input v-model="student.phone" type="text" class="form-control" id="phone" placeholder="Enter phone">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('phone')" class="invalid-feedback">{{ firstError('phone') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="content" :rules="validationRules.ruleRequired"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="content">{{ $t('messages.Content') }}</label>
                                            <ckeditor v-model="student.content"></ckeditor>
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('content')" class="invalid-feedback">{{ firstError('content') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">{{ $t('messages.Submit') }}</button>
                                </form>
                            </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal edit student -->
            <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{$t('messages.Edit Student')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ValidationObserver v-slot="{ handleSubmit }">
                                <form @submit.prevent="handleSubmit(updateStudent)">
                                    <ValidationProvider name="fullname" :rules="validationRules.ruleRequired"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="name">{{$t('messages.Full name')}}</label>
                                            <input v-model="oldStudent.editName" type="text" class="form-control" id="editName" placeholder="Enter name">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('name')" class="invalid-feedback">{{ firstError('name') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="email" :rules="validationRules.ruleEmail"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="email">{{$t('messages.Email')}}</label>
                                            <input v-model="oldStudent.editEmail" type="email" class="form-control" id="editEmail" placeholder="Enter email">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('email')" class="invalid-feedback">{{ firstError('email') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="phone" :rules="validationRules.rulePhone"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="phone">{{$t('messages.Phone')}}</label>
                                            <input v-model="oldStudent.editPhone" type="text" class="form-control" id="editPhone" placeholder="Enter phone">
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('phone')" class="invalid-feedback">{{ firstError('phone') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <ValidationProvider name="content" :rules="validationRules.ruleRequired"  v-slot="{ errors }">
                                        <div class="form-group">
                                            <label for="content">{{ $t('messages.Content') }}</label>
                                            <ckeditor v-model="oldStudent.editContent"></ckeditor>
                                            <span class="invalid-feedback">{{ errors[0] }}</span>
                                            <span v-if="hasError('content')" class="invalid-feedback">{{ firstError('content') }}</span>
                                        </div>
                                    </ValidationProvider>
                                    <button type="submit" class="btn btn-primary">{{$t('messages.Submit')}}</button>
                                </form>
                            </ValidationObserver>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-info" @click="logout">{{ $t('messages.Logout') }}</button>
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header">{{ $t('messages.List of students') }}</div>
                    <div class="card-body">
                       <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">{{ $t('messages.Full name') }}</th>
                                <th scope="col">{{ $t('messages.Email') }}</th>
                                <th scope="col">{{ $t('messages.Phone') }}</th>
                                <th scope="col">{{ $t('messages.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="student in studentData.data" :key="student.id">
                                    <th scope="row">{{student.id}}</th>
                                    <td>{{ student.name }}</td>
                                    <td>{{ student.email }}</td>
                                    <td>{{ student.phone }}</td>
                                    <td>
                                         <button type="button" v-bind:student="student" class="btn btn-primary" @click="viewDetail(student.id)" data-toggle="modal" data-target="#editStudent">
                                            {{ $t('messages.View') }}
                                        </button>
                                        <button type="button" @click="editStudent(student.id)" class="btn btn-primary" data-toggle="modal" data-target="#editStudent">
                                        {{ $t('messages.Edit') }}
                                        </button>
                                        <button type="button" @click="deleteStudent(student.id)" class="btn btn-danger">{{ $t('messages.Delete') }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="studentData" @pagination-change-page="getAllStudent"></pagination>
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
    name: "StudentList",
    data(){
        return {
            isRoleValid:false,
            errors : null,
            loading:true,
            student: {
                name:'',
                email:'',
                phone:'',
                content:''
            },
            oldStudent: {
                id:'',
                oldEmail:'',
                editName:'',
                editEmail:'',
                editPhone:'',
                editContent:''
            },
            studentData:{}
        }
    },
    computed: {
        ...mapGetters({
            getToken:'auth/getToken',
            getRoles:'auth/getRoles',
            authenticated:'auth/authenticated'
        })
    },
    mounted(){
        this.loading = false;
        this.getAllStudent();
    },
    methods:{
        viewDetail(id){
            this.$router.push(
                { 
                    name:'students-detail',
                    params:{
                        id:id,
                    }
                });
        },
        saveStudent(){
            axios.post('/api/students',this.student)
                .then(response=>{
                    this.student.name = ''
                    this.student.email = ''
                    this.student.phone = ''
                    this.student.content = ''
                    this.$toast.success(response.data.message)
                    this.getAllStudent();
                })
                .catch(err=>{
                    this.errors = err.response.data.errors;
                })
        },
        editStudent(id){
            axios.get('/api/students/'+ id) 
                .then(response => {
                    this.oldStudent.id = response.data.student.id
                    this.oldStudent.oldEmail = response.data.student.email
                    this.oldStudent.editName = response.data.student.name
                    this.oldStudent.editEmail = response.data.student.email
                    this.oldStudent.editPhone = response.data.student.phone
                    this.oldStudent.editContent = response.data.student.content
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                })
        },
        updateStudent(){
            var student = { 
                    name:this.oldStudent.editName,
                    email:this.oldStudent.editEmail,
                    oldEmail:this.oldStudent.oldEmail,
                    phone:this.oldStudent.editPhone,
                    content:this.oldStudent.editContent
            };
            axios.put('/api/students/'+ this.oldStudent.id,student)
                .then(response => {
                    this.oldStudent.editName = ''
                    this.oldStudent.editEmail = ''
                    this.oldStudent.editPhone = ''
                    this.oldStudent.editContent = ''
                    this.$toast.success(response.data.message)
                    this.getAllStudent();
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                    this.$toast.error(err.response.data.message);
                })
        },
        deleteStudent(id){
            if(confirm("Bạn muốn xóa không?")){
                axios.delete('/api/students/'+ id)
                    .then(response => {
                        this.getAllStudent();
                        this.$toast.success(response.data.message)
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message);
                })
            }
        },
        getAllStudent(page = 1){
            axios.get('api/students?page='+ page)
                .then(response => {
                    this.studentData = response.data.students;
                })
                .catch(err => {
                    this.$toast.error(err.response.data.message, 'Error')
                })
        },
        logout(){
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push('/')
                    .catch(err => {
                        
                    })
            })
            .catch(err=>{
                console.log(err);
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