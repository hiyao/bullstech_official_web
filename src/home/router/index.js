import Vue from 'vue'
import Router from 'vue-router'
import Front from '@home/components/Front'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Front',
      component: Front
    }
  ]
})
