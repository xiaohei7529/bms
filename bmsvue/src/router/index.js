import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/HelloWorld'
import YourComponent from '@/components/YourComponent'
import SidebarLayout from '@/components/user/SidebarLayout'
import bookDetails from '@/components/user/bookDetails'
import adminIndex from '@/components/admin/Index'
import adminLogin from '@/components/admin/Login'
import frontRoutes from './front';
import adminRoutes from './admin';
import NotFound from '../views/NotFound.vue'; // 导入404页面组件



Vue.use(Router)

const router =  new Router({
  mode: 'history', // 使用 history 模式
  routes: [
    // {
    //   path: '/',
    //   name: 'index',
    //   component:() => import('@/components/user/Index.vue'),
    //   meta: {
    //     requiresAuth: false
    //   }
    // },
    // {
    //   path: '/login',
    //   name: 'login',
    //   component:() => import('@/components/Login.vue'),
    //   meta: {
    //     requiresAuth: false
    //   }
    // },
    // {
    //   path: '/register',
    //   name: 'register',
    //   component:() => import('@/components/register.vue'),
    //   meta: {
    //     requiresAuth: false
    //   },
    // },
    // {
    //   path: '/t',
    //   name: 'YourComponent',
    //   component: YourComponent,
    //   meta: {
    //     requiresAuth: true
    //   }
    // },
    // {
    //   path: '/s',
    //   name: 'SidebarLayout',
    //   component: SidebarLayout,
    //   meta: {
    //     requiresAuth: true
    //   }
    // },
    // {
    //   path: '/bookDetails/:id',
    //   name: 'bookDetails',
    //   component: bookDetails,
    //   meta: {
    //     requiresAuth: false
    //   }
    // },

    // {
    //   path: '/adminIndex',
    //   name: 'adminIndex',
    //   component: adminIndex,
    //   meta: {
    //     requiresAuth: true
    //   }
    // },
    // {
    //   path: '/adminLogin',
    //   name: 'adminLogin',
    //   component: adminLogin,
    //   meta: {
    //     requiresAuth: false
    //   }
    // },
    ...frontRoutes, // 前台路由
    ...adminRoutes, // 后台路由
    {
      path: '*', // 404 页面
      // redirect: '/'
      component:NotFound 
    }
  ]
})


const whiteList = ['/login', '/register','/home','/adminLogin'];


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
        path: '/login',
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