const frontRoutes = [
    {
        path: '/',
        component: () => import('@/layouts/FrontLayout.vue'),
        children: [
          {
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
                requiresAuth: true
            }
          },
          {
            path: '/bookDetails/:id',
            name: 'bookDetails',
            component: () => import('@/views/front/bookDetails.vue'),
            meta: {
                requiresAuth: false
            }
          }
        ],
        meta: {
            requiresAuth: false
        }
      }
  ];
  
  export default frontRoutes;