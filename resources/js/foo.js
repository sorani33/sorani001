console.log("test");


window.Vue = require('vue');

// コンポーネントの使用１　基本
// Vue.component('my-component', {
//   template: `<p>aaaa</p>`
// });
//
// const app = new Vue({
//     el: '#app'
// });


// コンポーネントの使用２　ローカルに登録する。
// var myComponent = {
//   template:`<p>aaaa</p>`
// }
//
// new Vue({
//     el: '#app',
//     components:{
//       'my-component':myComponent
//     }
// });

// 親から子供
Vue.component('comp-child', {
  template: '<li>{{name}}HP.{{hp}}',
  props:['name', 'hp']
});

Vue.component('comp-child2', {
  template: '<button v-on:click="handleClick">イベント発火</button>',
  methods:{
     handleClick: function(){
       this.$emit('childs-event')
     }
  }
});


const app = new Vue({
    el: '#app',
    methods:{
      parentsMethods:function(){
        alert('キャッチ')
      }
    },

    data:{
      list:[
        {id:1, name:'スライム', hp:100},
        {id:2, name:'おおかみ', hp:180},
        {id:3, name:'ギガンテス', hp:300}
      ]
    }
});
