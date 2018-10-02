<template>
  <div style="padding-bottom: 100px;">
    <div class="nav-head p-15">
      <img :src="public_path+'/images/logo_brand.png'">
      <div class="links pull-right">
        <template v-if="authenticated">
          <router-link :to="{ name: 'home' }">
            {{ $t('home') }}
          </router-link>
        </template>
        <template v-else>
          <router-link :to="{ name: 'login' }">
            {{ $t('login') }}
          </router-link>
          |
          <router-link :to="{ name: 'register' }">
            {{ $t('register') }}
          </router-link>
        </template>
      </div>
    </div>
    <div  class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white">
      <div class="col-md-5">
        <div class="search-box">
          <i class="fa fa-search" aria-hidden="true" style="
            font-size: 30px;
            vertical-align: middle;
        "></i> 
            Find your dream Job
        </div>
        <br>
        <div class="title">
          Also, build your professional identity online and stay connected with opportunities.
          <a href="#">Create Account</a>
        </div>
      </div>
      <a href="/#openings" class="see-down">
        <i class="fa fa-angle-double-down icon" aria-hidden="true"></i>
      </a>
    </div>
    <div class="container">
      <h4 class="mb-5 mt-5"><a href="#openings" name="openings">#</a> Recent Openings</h4>
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card  profile-card-2">
            <div class="card-img-block">
              <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
            </div>
            <div class="card-body">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ESrIBaeH36xzs-kYsI4t9qGIkJ_j1hFuMz6CotRsramDblPFiw" alt="profile-image"
                class="profile" />
              <h5 class="card-title">Swift Developer</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <div class="icon-block text-left">
                  <span>48 minutes ago</span>
              </div>

            </div>
          </div>

        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card profile-card-2">
            <div class="card-img-block">
              <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
            </div>
            <div class="card-body">
              <img src="https://ucarecdn.com/cc6abaa3-acab-4ce7-a0fd-a0ef563ef08c/" alt="profile-image" class="profile" />
              <h5 class="card-title">Full Stack Web Developer</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <div class="icon-block text-left">
                  <span>1 hour ago</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <h4 class="mb-5 mt-5"><a href="#openings" name="openings">#</a> Companies</h4>
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="card profile-card-4">
            <div class="card-img-block">
              <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
            </div>
            <div class="card-body pt-5">
              <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                alt="profile-image" class="profile" />
              <h5 class="card-title text-center">Nexseed Inc .</h5>
              <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <div class="text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Learn more</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">View jobs</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card profile-card-4">
            <div class="card-img-block">
              <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
            </div>
            <div class="card-body pt-5">
              <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                alt="profile-image" class="profile" />
              <h5 class="card-title text-center">Nexseed Inc .</h5>
              <p class="card-text text-center">Language School</p>
              <p class="card-text text-center">50-200 employees...</p>
              <p class="card-text text-center">Cebu City, PH</p>
              <div class="text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">Learn more</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">View jobs</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',
  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('home') }
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

<style lang="scss" scoped>
.nav-head{
  position: absolute;
  width: 100%;
  z-index: 1000;
}
.links > a {
    color: #636b6f;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}

.title {
  font-size: 15px;
}
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;
}
.search-box{
  padding: 10px;
  border-bottom: 2px solid #e4e4e4;
  background: white;
  background: beige;
  border-radius: 10px;
}
.see-down{
  position: absolute;
  bottom: 10px;
  border-radius: 50%;
  height: 40px;
  width: 40px;
  background: #9e9e9e;
  .icon{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: white;
  }
}
</style>
