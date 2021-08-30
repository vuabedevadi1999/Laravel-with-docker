import Vue from 'vue';
import VueI18n from 'vue-i18n';
import en from '../lang/en.json';
import vi from '../lang/vi.json';
Vue.use(VueI18n);
let lang = 'en';
if(localStorage.getItem('lang')=='vn'){
    lang = 'vi';
}
export default new VueI18n({
    locale:lang,
    messages:{
        vi:{
            fields: {
                fullname:"Họ và tên",
                email: "Địa chỉ email",
                password: "Mật khẩu",
                phone:"Số điện thoại",
                avatar: "Ảnh đại diện",
                content:"Nội dung",
                birthday:"Ngày sinh"
            },
            validation: vi.messages,
            messages:vi.messages
        },
        en:{
            fields: {
                fullname:"full name",
                email: "email",
                password: "password",
                phone:"phone",
                avatar: "avatar",
                content: "content",
                birthday: "birthday"
            },
            validation: en.messages,
            messages: en.messages
        }
    }
})