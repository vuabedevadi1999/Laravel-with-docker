import i18n from '../i18n';
import { configure,extend } from "vee-validate";
import { required, min , max ,confirmed , image} from "vee-validate/dist/rules";
export const validateForm = {
    data(){
        return {
            validationRules:{
                ruleEmail:'required',
                rulePassword:'required|min:6|max:12',
                ruleRequired:'required',
                rulePasswordConfirm:'required|min:6|max:12|confirmed:profile.newPassword',
                rulePhone:'required|phone',
                ruleImage:'required|image'
            },
            modelConfig: {
                type: 'string',
                mask: 'YYYY-MM-DD', // Uses 'iso' if missing
            },
        }
    },
    methods:{
        containsKey(obj, key ) {
            return Object.keys(obj).includes(key);
        },
        hasError(key){
            if(this.errors){
                return this.containsKey(this.errors,key);
            }
            return false;
        },
        firstError(key){
            return this.errors[key][0];
        }
    }
}
configure({
    defaultMessage: (field, values) => {
        values._field_ = i18n.t(`fields.${field}`);
        return i18n.t(`validation.${values._rule_}`, values);
    }
  });

const regex = {
    regEmail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
    regPhone: /(0)[0-9]{9}$/
}
const regEmail = new RegExp(regex.regEmail);
const regPhone = new RegExp(regex.regPhone);
extend("confirmed", confirmed);
extend("required", required);
extend("image", image);
extend("email", {
    validate: value => {
        return regEmail.test(value)
    }
});
extend("phone", {
    validate: value => {
        return regPhone.test(value)
    }
});
extend("min", min);
extend("max", max);
