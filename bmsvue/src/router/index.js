import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/HelloWorld'
import YourComponent from '@/components/YourComponent'
import SidebarLayout from '@/components/user/SidebarLayout'
import AdminIndex from '@/components/admin/Index'


Vue.use(Router)

const router =  new Router({
  mode: 'history', // 使用 history 模式
  routes: [
    {
      path: '/',
      name: 'index',
      component:() => import('@/components/user/Index.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/login',
      name: 'login',
      component:() => import('@/components/Login.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/register',
      name: 'register',
      component:() => import('@/components/register.vue'),
      meta: {
        requiresAuth: false
      },
    },
    {
      path: '/t',
      name: 'YourComponent',
      component: YourComponent,
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/s',
      name: 'SidebarLayout',
      component: SidebarLayout,
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/admin',
      name: 'AdminIndex',
      component: AdminIndex,
      meta: {
        requiresAuth: false
      }
    },
  ]
})


const whiteList = ['/login', '/register','/home','/admin'];


// 全局路由守卫
router.beforeEach((to, from, next) => {
  // 从存储中获取 token
  const token = localStorage.getItem('token'); 

  console.log(to);
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // 如果路由需要认证且没有 token，重定向到登录页
    if (!token) {
      // 当前界面是登录页，不重定向
      if (whiteList.indexOf(to.path) !== -1) {
        return next();
      }

      return next({
        path: '/home',
        query: {
          redirect: Math.random()
        }
      });

    } else {
      next(); // 继续导航
    }
  } else {
    next(); // 不需要认证，继续导航
  }
});


export default router;