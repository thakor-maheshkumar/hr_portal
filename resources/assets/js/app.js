
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
var VueResource = require('vue-resource');
Vue.use(VueResource);
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use( CKEditor );
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//var ClassicEditor = require('@ckeditor/ckeditor5-build-classic');
//window.ClassicEditor = require('@ckeditor/ckeditor5-build-classic');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import question from './components/Questions.vue';
import descriptive from './components/Descriptive.vue';
import optional from './components/Optional.vue';
import user from './components/user.vue';
Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

const routes = [
  { path: '/user', component: user },
]
const router = new VueRouter({
	mode: 'history',
    routes
})
const app = new Vue({
    el: '#app',
    router: router,

    components: { 'question':question,

    			'descriptive':descriptive,
    			'optional':optional,
    			'user':user
     },
});
