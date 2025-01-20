// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

import http from './utils/http'; // 引入自定义的 Axios 实例
Vue.prototype.$http = http; // 将 Axios 实例挂载到 Vue 原型

import cors from 'cors';
Vue.use(cors)

import GeminiScrollbar from 'vue-gemini-scrollbar'
Vue.use(GeminiScrollbar)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  components: { App },
  template: '<App/>'
})
