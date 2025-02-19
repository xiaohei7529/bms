const frontRoutes = [{
  path: '/',
  component: () => import('@/layouts/FrontLayout.vue'),
  children: [{
      path: '',
      name: 'Home',
      component: () => import('@/views/front/Home.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/components/Login.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('@/components/register.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/product',
      name: 'Product',
      component: () => import('@/views/front/Product.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/bookDetails/:id',
      name: 'bookDetails',
      component: () => import('@/views/front/bookDetails.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/searchList',
      name: 'searchList',
      component: () => import('@/views/front/searchList.vue'),
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/userInfo',
      name: 'userInfo',
      component: () => import('@/views/front/userInfo.vue'),
      meta: {
        requiresAuth: true
      },
      children: [
        {
          path: '/bookFavorite',
          name: 'bookFavorite',
          component: () => import('@/views/front/bookFavorite.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/bookBorrowed',
          name: 'bookBorrowed',
          component: () => import('@/views/front/bookBorrowed.vue'),
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/bookPending',
          name: 'bookPending',
          component: () => import('@/views/front/bookPending.vue'),
          meta: {
            requiresAuth: true
          }
        }
      ]

    }
  ],
  meta: {
    requiresAuth: false
  }
}];

export default frontRoutes;