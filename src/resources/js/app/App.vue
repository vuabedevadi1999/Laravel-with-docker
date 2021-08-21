<template>
    <div>
        <div class="navbar">
            <div>
                <router-link :to="{ name: 'home'}">{{ $t('messages.Home') }}</router-link>
            </div>
            <div>
                <router-link :to="{ name: 'login'}">{{ $t('messages.Login') }}</router-link>
            </div>
            <div>
                <router-link :to="{ name: 'students'}">{{ $t('messages.List of students') }}</router-link>
            </div>
            <div>
                <router-link :to="{ name: 'profile'}">{{ $t('messages.Profile') }}</router-link>
            </div>
            <select v-model="lang" @change="handleChangeLanguage($event)">
                <option value="en">English</option>
                <option value="vn">Viet Nam</option>
            </select>
        </div>
        <router-view></router-view>
    </div>
    
</template>
<script>
export default {
    name: "Home",
    data(){
        const lang = localStorage.getItem('lang') || 'en'
        return {
            lang:lang,
        }
    },
    methods:{
        handleChangeLanguage(event){
            localStorage.setItem('lang',event.target.value);
            if(localStorage.getItem('lang')=='vn'){
                this.$i18n.locale = 'vi';
            }else{
                this.$i18n.locale = this.lang;
            }
        }
    }
}
</script>
<style scoped>
    .navbar{
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #FFF;
        border-bottom: 1px solid #EEE ;
        color: blue;
    }
    .navbar div{
        padding: 10px 20px;
        margin: 5px;
    }
</style>