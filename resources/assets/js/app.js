
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

Vue.component('salary', function (resolve) {require(['./components/salary/Salary'], resolve)});
Vue.component('consolidated', function (resolve) { require(['./components/reports/Сonsolidated'], resolve)});
Vue.component('costs', function (resolve) { require(['./components/finance/Costs'], resolve)});
Vue.component('sidebar', function (resolve) { require(['./components/sidebar/Sidebar'], resolve)});
Vue.component('personal-position', function (resolve) { require(['./components/personal/PersonalPosition'], resolve)});
Vue.component('personal-table', function (resolve) { require(['./components/personal/PersonalTable'], resolve)});
Vue.component('employees-card', function (resolve) { require(['./components/employees/EmployeesCard'], resolve)});
Vue.component('productivity', function (resolve) { require(['./components/productivity/Productivity'], resolve)});
Vue.component('project-show', function (resolve) { require(['./components/projects/ProjectShow'], resolve)});
Vue.component('project', function (resolve) { require(['./components/projects/Project'], resolve)});
Vue.component('active-collab', function (resolve) { require(['./components/activeCollab/ActiveCollab'], resolve)});
Vue.component('widget-time', function (resolve) { require(['./components/widget/WidgetTime'], resolve)});

import Vuex from 'vuex';
import BootstrapVue from 'bootstrap-vue';

import personal from './store/personal';

Vue.use(Vuex);

Vue.use(BootstrapVue);

const store = new Vuex.Store({
    modules: {
        personal
    },
    strict: false
});

const app = new Vue({
    el: '#app',
    store,
    methods: {
        burgerToggle(){
            this.$refs.sidebar.classList.toggle('hide-sidebar');            
        }
    }
});
