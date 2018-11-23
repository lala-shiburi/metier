const UsersPage = () => import('~/pages/admin/user/search/index').then(m => m.default || m)
const Dashboard = () => import('~/pages/admin/dashboard/index').then(m => m.default || m)
const CompanyPage = () => import('~/pages/admin/company/index').then(m => m.default || m)
const OpeningPage = () => import('~/pages/admin/opening/index').then(m => m.default || m)

export default [
  { path: '/admin/users', name: 'admin.users', component: UsersPage },
  { path: '/admin/dashboard', name: 'admin.dashboard', component: Dashboard },
  { path: '/admin/company', name: 'admin.company', component: CompanyPage },
  { path: '/admin/opening', name: 'admin.opening', component: OpeningPage },
]
