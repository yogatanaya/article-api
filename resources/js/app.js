
require('./bootstrap');

window.Vue = require('vue');

Vue.component('navbar', require('./components/navbar.vue').default);
Vue.component('articles', require('./components/articles.vue').default);

const app = new Vue({
    el: '#app',
});
