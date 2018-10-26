const UsersPage = () => import('~/pages/admin/user/search/index').then(m => m.default || m)
const Dashboard = () => import('~/pages/admin/user/search/index').then(m => m.default || m)

export default [
  { path: '/admin/users', name: 'admin.users', component: UsersPage },
  { path: '/admin/dashboard', name: 'admin.dashboard', component: Dashboard },
]
