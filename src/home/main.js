// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
// commit tes
import Vue from 'vue'
import App from './App'
import router from './router'
import 'expose-loader?$!expose-loader?window.jQuery!expose-loader?jQuery!jquery'
import 'bootstrap'
import BootstrapVue from 'bootstrap-vue'
import CheckboxRadio from 'vue-checkbox-radio';
//uncomment this if you use bootstrap-vue

// vue debug mode
const isDebug_mode = process.env.NODE_ENV !== 'production';
Vue.config.debug = isDebug_mode;
Vue.config.devtools = isDebug_mode;
Vue.config.productionTip = true;

Vue.use(BootstrapVue);
Vue.use(CheckboxRadio);

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
});
