function page (path) {
  return () => import(`~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'home', component: page('home.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },

  { path: '/blogs', name: 'blogs', component: page('blogs/index.vue') },
  { path: '/blogs/add', name: 'blogs.add', component: page('blogs/form.vue') },
  { path: '/blogs/edit/:blogId', name: 'blogs.edit', component: page('blogs/form.vue'), props: true },
  { path: '/blogs/:blogId', name: 'blogs.view', component: page('blog.vue'), props: true },

  { path: '*', component: page('errors/404.vue') }
]
