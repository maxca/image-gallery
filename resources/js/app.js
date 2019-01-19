/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
console.log('onls1')
require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('usage-overview', require('./components/UsageOverView'));
Vue.component('usage-compositions', require('./components/UsageCompositions'));
Vue.component('upload-panel', require('./components/UploadPanel'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });


const uploadPanel = new Vue({
    el: '#image-upload',
    data: {
        items: [],
        showDelBtn: false,
        mounted:function(){
            this.getImages(); //method1 will execute at pageload
        },
    }
});

const usageOverview = new Vue({
    el: '#usage-overview',
    data: {
        items: [],
        mounted: function () {
            this.getOverview();
        },
    }
});

const usageCompositions = new Vue({
    el: '#usage-compositions',
    data: {
        datas: [],
        mounted: function () {
            this.getUsageCompositions();
        },
    }
});
