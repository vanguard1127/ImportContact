require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
import VuePapaParse from 'vue-papa-parse';
import Vuelidate from 'vuelidate';
import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(VuePapaParse)
Vue.use(Vuelidate);

const app = new Vue({
    el: '#app',
    render: h => h(App),
});
