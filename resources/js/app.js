/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import moment from 'moment';
var moment_timezone = require('moment-timezone');
moment(moment_timezone);
//moment.tz.setDefault("UTC");
//console.log(window.timezone);
window.moment = moment;
window.Vue = require('vue');

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('dashboard-index-component', require('./components/dashboard/Index.vue').default);
Vue.component('setup-index-component', require('./components/setup/Index.vue').default);
Vue.component('uninstall-component', require('./components/setup/Uninstall.vue').default);
Vue.component('offers-list-component', require('./components/offers/List.vue').default);
Vue.component('offers-createedit-component', require('./components/offers/CreateEdit.vue').default);
Vue.component('display-index-component', require('./components/display/Index.vue').default);
Vue.component('need-help', require('./components/NeedHelp').default);


const app = new Vue({
    el: '#app',
    data(){
        return{
            showPopup:false,
            showInstallPopup:false,
        }
    },
    methods: {
        setupPopup: function () {
            var element = document.getElementById("app-popup");
            element.classList.remove("d-none");
            this.showPopup = !this.showPopup;
        },
        show2Popup: function () {
            this.showPopup = false;
            var element = document.getElementById("app-popup-install");
            element.classList.remove("d-none");
            this.showInstallPopup = !this.showInstallPopup;
        }
    },
});

