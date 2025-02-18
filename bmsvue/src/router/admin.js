const adminRoutes = [
    {
        path: '/admin',
        component: () => import('@/layouts/AdminLayout.vue'),
        children: [
          {
            path: '',
            name: 'Dashboard',
            component: () => import('@/views/admin/Dashboard.vue'),
            meta: {
                requiresAuth: false
            }
          },
          {
            path: 'user',
            name: 'UserManage',
            component: () => import('@/views/admin/UserManage.vue'),
            meta: {
                requiresAuth: false
            }
          },
          {
            path: 'booklist',
            name: 'booklist',
            component: () => import('@/views/admin/booklist.vue'),
            meta: {
                requiresAuth: true
            }
          },
          {
            path: 'bookaudit',
            name: 'bookaudit',
            component: () => import('@/views/admin/bookaudit.vue'),
            meta: {
                requiresAuth: true
            }
          },
          {
            path: 'bookcategory',
            name: 'bookcategory',
            component: () => import('@/views/admin/bookcategory.vue'),
            meta: {
                requiresAuth: true
            }
          }
          
        ],
        meta: {
            requiresAuth: false
        }
      }
  ];
  
  export default adminRoutes;