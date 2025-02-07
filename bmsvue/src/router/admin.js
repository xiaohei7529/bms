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
          }
        ],
        meta: {
            requiresAuth: false
        }
      }
  ];
  
  export default adminRoutes;