console.log("test");


window.Vue = require('vue');
Vue.component('my-component', {
  template: `<p>aaaa</p>`
});

const app = new Vue({
    el: '#app'
});
