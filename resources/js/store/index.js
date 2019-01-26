import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'

Vue.use(Vuex)  //他ファイルで、this.$storeが使える。

const store = new Vuex.Store({
  modules: {
    auth
  }
})

export default store
