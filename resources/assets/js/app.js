
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('salary', require('./components/Salary'));
Vue.component('report-index', require('./components/Report'));
Vue.component('costs', require('./components/finance/Costs'));
Vue.component('sidebar', require('./components/sidebar/Sidebar'));
Vue.component('personal-position', require('./components/personal/PersonalPosition'));
Vue.component('personal-table', require('./components/personal/PersonalTable'));

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

const app = new Vue({
    el: '#app'
});
