
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./../../../node_modules/admin-lte/plugins/iCheck/icheck.js');

require('./../../../node_modules/admin-lte/dist/js/adminlte.js');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
});

Vue.component('salary', require('./components/Salary.vue'));
Vue.component('report-index', require('./components/Report.vue'));

const app = new Vue({
    el: '#app'
});
