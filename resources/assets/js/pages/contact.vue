<template>
  <div>
    <header class="header-global">
      <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light">
        <div class="container">
          <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand mr-lg-5">
            <img :src="public_path + '/images/logo_brand.png'">
          </router-link>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-collapse collapse" id="navbar_global">
            <div class="navbar-collapse-header">
              <div class="row">
                <div class="col-6 collapse-brand">
                  <router-link :to="{ name: 'welcome' }">

                    <a href="">
                      <img :src="public_path + '/images/logo_brand.png'">
                    </a>
                  </router-link>
                </div>
                <div class="col-6 collapse-close">
                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                  </button>
                </div>
              </div>
            </div>
            <ul class="navbar-nav navbar-nav-hover align-items-lg-center">
              <li class="nav-item dropdown">
                <router-link :to="{ name: 'company.search' }" class="nav-link" data-toggle="dropdown" role="button" active-class="active">
                  <i class="ni ni-ui-04 d-lg-none"></i>
                  <span class="nav-link-inner--text">Companies</span>
                </router-link>
              </li>
              <li class="nav-item dropdown">
                <router-link :to="{ name: 'opening.search' }" class="nav-link" data-toggle="dropdown" role="button" active-class="active">
                  <i class="ni ni-collection d-lg-none"></i>
                  <span class="nav-link-inner--text">Openings</span>
                </router-link>
              </li>
            </ul>

            <ul class="navbar-nav align-items-lg-center ml-lg-auto">
              <template v-if="authenticated">
                <li class="nav-item">
                  <router-link :to="{ name: 'home' }" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon">
                      <i class="fa fa-user mr-2"></i>
                    </span>
                    <span class="">Dashboard</span>
                  </router-link>
                </li>
              </template>
              <template v-else>
                <li class="nav-item">
                  <router-link :to="{ name: 'register' }" class="nav-link nav-link-icon" active-class="active" data-toggle="tooltip" title="Register">
                    <span class="nav-link-inner--text">Register</span>
                  </router-link>
                </li>
                <li class="nav-item">
                  <router-link :to="{ name: 'login' }" class="nav-link nav-link-icon" active-class="active" data-toggle="tooltip" title="Login">
                    <span class="nav-link-inner--text ">Login</span>
                  </router-link>

                </li>
                <li class="nav-item">
                  <router-link :to="{ name: 'register' }" class="btn btn-neutral btn-icon" active-class="active" data-toggle="tooltip" title="Register">
                    <span class="btn-inner--icon">
                      <i class="fa fa-user mr-2"></i>
                    </span>
                    <span class="">Employers</span>
                  </router-link>
                </li>
              </template>

            </ul>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="position-relative">
        <section class="section-hero section-shaped my-0" style="background: linear-gradient(150deg, #281483 15%, #8f6ed5 70%, #d782d9 94%)">
          <div class="shape shape-style-1 shape-primary">
            <span class="span-150"></span>
            <span class="span-50"></span>
            <span class="span-50"></span>
            <span class="span-75"></span>
            <span class="span-100"></span>
            <span class="span-75"></span>
            <span class="span-50"></span>
            <span class="span-100"></span>
            <span class="span-50"></span>
            <span class="span-100"></span>
          </div>
          <div class="container-fluid shape-container d-flex">
            <!--align-items-center-->
            <div class="col px-0">
              <div class="row justify-content-center">
                <!--align-items-center-->
                <div class="col-lg-7 text-center pt-lg">
                  <h3 class="text-white">Jobseed</h3>
                  <p class="lead text-white mt-4 mb-5">Build your professional identity online and stay connected with opportunities.</p>
                </div>
              </div>
              <div class="row align-items-center justify-content-around stars-and-coded">
                <div class="col-md-2">
                  <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content
                        is a little bit longer.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content
                        is a little bit longer.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content
                        is a little bit longer.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content
                        is a little bit longer.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                      </div>
                    </div>
                  </div>
                </div>                
                <div class="col-md-2">
                  <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap">
                    <div class="card-body">
                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content
                        is a little bit longer.</p>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                          <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                        </div>
                        <small class="text-muted">9 mins</small>
                      </div>
                    </div>
                  </div>
                </div>                
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>


    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>

      <div class="links">
        <a href="https://laravel.com/docs">Documentation</a>
        <a href="https://laracasts.com">Laracasts</a>
        <a href="https://laravel-news.com">News</a>
        <a href="https://forge.laravel.com">Forge</a>
        <a href="https://github.com/laravel/laravel">GitHub</a>
      </div>
    </div>

    <footer/>

  </div>
</template>

<script>
  // import Navbar from '~/components/Navbar'
  import {
    mapGetters
  } from 'vuex'

  export default {
    layout: 'welcome',

    metaInfo() {
      return {
        title: this.$t('home')
      }
    },

    data: () => ({
      title: window.config.appName,
      public_path: location.origin
    }),

    computed: mapGetters({
      authenticated: 'auth/check'
    })
  }

</script>

<style scoped>
  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .title {
    font-size: 85px;
  }

  .cover-container {
    max-width: 42em;
  }

</style>
