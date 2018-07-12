const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const UserProfile = () => import('~/pages/user/index').then(m => m.default || m)
const CompanyProfile = () => import('~/pages/company/index').then(m => m.default || m)
const OpeningProfile = () => import('~/pages/opening/index').then(m => m.default || m)
const UserCompanies = () => import('~/pages/user/companies').then(m => m.default || m)
const CompanyCreate = () => import('~/pages/company/create').then(m => m.default || m)
const OpeningCreate = () => import('~/pages/opening/create').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/home', name: 'home', component: Home },
  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profiled', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  // company routes
  { path: '/company/profile/:id', name: 'company.profile', component: CompanyProfile },
  { path: '/company/create', name: 'company.create', component: CompanyCreate },

  // user routes
  { path: '/profile/:id?', name: 'user.profile', component: UserProfile },
  { path: '/user/companies', name: 'user.companies', component: UserCompanies },

  // opening routes
  { path: '/opening/profile/:id', name: 'opening.profile', component: OpeningProfile },
  { path: '/company/:company_id/opening/create', name: 'opening.create', component: OpeningCreate },
  

  { path: '*', component: NotFound }
]
