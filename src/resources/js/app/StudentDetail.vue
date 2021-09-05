<template>
    <div v-if="loading">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div v-else >
        <button class="btn btn-primary ml-2 mt-2">
            <router-link :to="{ name: 'students'}">{{ $t('messages.back') }}</router-link>
        </button>
        <div class="card bg-light mb-3 mx-auto mt-2" style="max-width: 60rem;">
            <div class="card-header">
                <b>{{ $t('messages.Full name') }}: {{ this.student.name}}</b><br>
                <b>{{ $t('messages.Email') }}: {{ this.student.email}}</b><br>
                <b>{{ $t('messages.Phone') }}: {{ this.student.phone}}</b><br>
            </div>
            <div class="card-body">
                <h5 class="card-title"><b>{{ $t('messages.Content') }}</b></h5>
                <p class="card-text" v-html="this.student.content">
                </p>
            </div>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default {
    data(){
        return {
            loading:true,
            student:{}
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
        this.getStudent(this.$route.params.id);
    },
    methods:{
        getStudent(id){
            axios.get('/api/students/'+ id) 
                .then(response => {
                    this.student = response.data.student;
                })
                .catch(err => {
                    
                })
        }
    }
}
</script>
<style scoped>

</style>