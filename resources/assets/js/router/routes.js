const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)
const PrivacyPolicy = () => import('~/pages/legal/privacy-policy').then(m => m.default || m)
const TCoS = () => import('~/pages/legal/terms-conditions-of-service').then(m => m.default || m)
const ContactUs = () => import('~/pages/contact-us/index').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)

// user pages
const UserProfile = () => import('~/pages/user/index').then(m => m.default || m)
const ApplicationProgress = () => import('~/pages/user/application-progress-page').then(m => m.default || m)
const UserSavedOpenings = () => import('~/pages/user/saved-openings/index').then(m => m.default || m)
const UserOpenings = () => import('~/pages/user/openings/index').then(m => m.default || m)
const UserSearch = () => import('~/pages/user/search/index').then(m => m.default || m)
const UserCompanySavedUsers = () => import('~/pages/user/saved-users/index').then(m => m.default || m)

// company pages
const CompanyProfile = () => import('~/pages/company/index').then(m => m.default || m)
const CompanyHiringApplicants = () => import('~/pages/company/hiringApplicants').then(m => m.default || m)
const CompanyApplicants = () => import('~/pages/hiring/application-list').then(m => m.default || m)
const CompanyApplicantsSubmitted = () => import('~/pages/hiring/application-list-components/submitted-applications').then(m => m.default || m)
const CompanyApplicantsInProgress = () => import('~/pages/hiring/application-list-components/in-progress-applications').then(m => m.default || m)
const CompanyApplicantsInActive = () => import('~/pages/hiring/application-list-components/inactive-applications').then(m => m.default || m)
const CompanyApplicantsFinished = () => import('~/pages/hiring/application-list-components/finished-applications').then(m => m.default || m)
const CompanyHiringProcesses = () => import('~/pages/company/hiringProcesses').then(m => m.default || m)
const CompanyHiringProcessesCreate = () => import('~/pages/hiring-process/edit').then(m => m.default || m)
const FollowedCompanies = () => import('~/pages/user/followed-companies/index').then(m => m.default || m)

// opening pages
const OpeningProfile = () => import('~/pages/opening/index').then(m => m.default || m)
const UserCompanies = () => import('~/pages/user/companies/index').then(m => m.default || m)
const OpeningApply = () => import('~/pages/opening/apply/index').then(m => m.default || m)
const HiringApplications = () => import('~/pages/user/applications/index').then(m => m.default || m)
const CompanyCreate = () => import('~/pages/company/create').then(m => m.default || m)
const OpeningCreate = () => import('~/pages/opening/create').then(m => m.default || m)
const OpeningEdit = () => import('~/pages/opening/edit').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)
const SearchCompanyPage = () => import('~/pages/company/search').then(m => m.default || m)
const SearchOpeningPage = () => import('~/pages/opening/search/index').then(m => m.default || m)

// dashboard
const RecruiterDashboard = () => import('~/pages/dashboard/recruiter').then(m => m.default || m)
const ApplicantDashboard = () => import('~/pages/dashboard/applicant').then(m => m.default || m)

const Welcome = () => import('~/pages/guest/welcome').then(m => m.default || m)

export default [
  { path: '/', name: 'welcome', component: Welcome },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/home', name: 'home', component: ApplicantDashboard },

  // dashboards
  { path: '/dashboard/recruiter', name: 'dashboard.recruiter', component: RecruiterDashboard },
  { path: '/dashboard/applicant', name: 'dashboard.applicant', component: ApplicantDashboard },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },

  // company routes
  { path: '/company/profile/:id', name: 'company.profile', component: CompanyProfile },
  { path: '/company/create', name: 'company.create', component: CompanyCreate },
  { path: '/company/:id/hiringapplicants', name: 'company.hiringapplicants', component: CompanyHiringApplicants },
  { path: '/company/:id/hiringprocceses', name: 'company.hiringprocceses', component: CompanyHiringProcesses },
  { path: '/company/:company_id/hiringprocceses/create/:id?', name: 'company.hiringprocceses.create', component: CompanyHiringProcessesCreate },
  { path: '/company/search', name: 'company.search', component: SearchCompanyPage },
  { path: '/company/:id/applications', component: CompanyApplicants,
    children: [
      {path: '', redirect: { name: 'company.applicants.submitted' }},
      {path: 'submitted', name: 'company.applicants.submitted', component: CompanyApplicantsSubmitted},
      {path: 'in-progress', name: 'company.applicants.in_progress', component: CompanyApplicantsInProgress},
      {path: 'finished', name: 'company.applicants.finished', component: CompanyApplicantsFinished},
      {path: 'inactive', name: 'company.applicants.inactive', component: CompanyApplicantsInActive},
    ]
  },

  // user routes
  { path: '/profile/:id?', name: 'user.profile', component: UserProfile },
  { path: '/user/companies', name: 'user.companies', component: UserCompanies },
  { path: '/user/followed/companies', name: 'user.followed.companies', component: FollowedCompanies },
  { path: '/user/application/progress/:application_id', name: 'user.application.progress', component: ApplicationProgress },
  { path: '/user/saved/openings', name: 'user.saved.openings', component: UserSavedOpenings },
  { path: '/user/openings', name: 'user.openings', component: UserOpenings },
  { path: '/user/search', name: 'user.search', component: UserSearch },
  { path: '/user/company/saved/user', name: 'user.company.saved.user', component: UserCompanySavedUsers },

  // opening routes
  { path: '/opening/profile/:id', name: 'opening.profile', component: OpeningProfile },
  { path: '/opening/search/:keyword?', name: 'opening.search', component: SearchOpeningPage },
  { path: '/opening/:id/edit', name: 'opening.edit', component: OpeningEdit },
  { path: '/company/:company_id/opening/create', name: 'opening.create', component: OpeningCreate },
  
  // application
  { path: '/applications', name: 'hiringApplication.applications', component: HiringApplications },
  { path: '/applications/:application_id', name: 'hiringApplication.application', component: ApplicationProgress },
  { path: '/opening/apply/:opening_id/:applicant_id?', name: 'hiringApplication.create', component: OpeningApply },

  // legal pages
  { path: '/privacy-policy', name:'privacy-policy', component: PrivacyPolicy },
  { path: '/terms-and-conditions-of-service', name:'terms-and-conditions-of-service', component: TCoS },
  { path: '/contact-us', name:'contact-us', component: ContactUs },

  { path: '/404', name:'404', component: NotFound },
  { path: '*', component: NotFound }
]
