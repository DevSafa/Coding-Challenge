

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('categories-component', require('./components/CategoriesComponent.vue').default);


const app = new Vue({
    el: '#app',
});