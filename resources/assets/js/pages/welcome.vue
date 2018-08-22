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
          <opening-card>
            <h1>gdf</h1>
          </opening-card>
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
              <div class="row justify-content-center hero-center-title">
                <!--align-items-center-->
                <div class="col-lg-5 col-md-7 col-sm-10 text-center pt-lg">
                  <div class="card">
                    <div class="card-body" id="card-hero-carousel">
                      <h5 class="card-title">Over 100,000 IT Jobs</h5>
                      <p class="card-text">Search jobs anywhere in the philippines. Nationwide</p>
                      <a href="#" class="btn btn-primary btn-hero-nt-opp">Signup Free</a>
                      <a href="#" class="btn btn-primary btn-hero-opp">Search Jobs</a>

                    </div>
                  </div>

                </div>
              </div>
              <div class="row align-items-center justify-content-around stars-and-coded">
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card profile-card-2">
                    <div class="card-img-block">
                      <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
                    </div>
                    <div class="card-body pt-5">
                      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ5ESrIBaeH36xzs-kYsI4t9qGIkJ_j1hFuMz6CotRsramDblPFiw" alt="profile-image"
                        class="profile" />
                      <h5 class="card-title">Swift Developer</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <div class="icon-block">
                        <a href="#">
                          <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-google-plus"></i>
                        </a>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card profile-card-2">
                    <div class="card-img-block">
                      <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
                    </div>
                    <div class="card-body pt-5">
                      <img src="https://ucarecdn.com/cc6abaa3-acab-4ce7-a0fd-a0ef563ef08c/" alt="profile-image" class="profile" />
                      <h5 class="card-title">Full Stack Web Developer</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <div class="icon-block">
                        <a href="#">
                          <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-google-plus"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">

                  <div class="card profile-card-2">
                    <div class="card-img-block">
                      <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
                    </div>
                    <div class="card-body pt-5">
                      <img src="https://www.accenture.com/t20170407T081136Z__w__/us-en/_acnmedia/Accenture/Conversion-Assets/Careers/Images/LandingPage/58/Accenture-Explore-08"
                        alt="profile-image" class="profile" />
                      <h5 class="card-title">Python Developer</h5>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <div class="icon-block">
                        <a href="#">
                          <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-google-plus"></i>
                        </a>
                      </div>
                    </div>
                  </div>


                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card profile-card-2">
                    <div class="card-img-block">
                      <img class="img-fluid" :src="public_path + '/images/feat-welcome-card.jpg'" alt="Card image cap">
                    </div>
                    <div class="card-body pt-5">
                      <img src="data:image/png;base64,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"
                        alt="profile-image" class="profile" />
                      <a href="#">
                        <h5 class="card-title">Laravel Developer</h5>
                      </a>
                      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                      <div class="icon-block">
                        <a href="#">
                          <i class="fa fa-facebook"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#">
                          <i class="fa fa-google-plus"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <div class="album py-5 bg-light" id="company-cont-body">
        <div class="container">
          <div class="row">

            <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
              <h1 class="display-4">Company</h1>
              <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam dignissimos vero aspernatur suscipit modi.</p>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="card profile-card-4">
                <div class="card-img-block">
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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
                  <div class="info-box">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua.</div>
                  <img class="img-fluid" src="https://mdbootstrap.com/img/Photos/Others/images/48.jpg" alt="Card image cap">
                </div>
                <div class="card-body pt-5">
                  <img src="https://obs.line-scdn.net/0hQeeW3D9hDkpYLiKnDRFxHXZ9CDE0QxlZMxYCcGNvEyQgWhtZekhBLX8sV3lxcB1JYkEVeSh7TH9xF0oAYU9JKGF-FXtzTE5LMRxI/f280x280"
                    alt="profile-image" class="profile" />
                  <h5 class="card-title text-center">Gail Schmidt</h5>
                  <p class="card-text text-center">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <div class="d-flex justify-content-between align-items-center">
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

      <div class="album bg-light">
        <div class="container-fluid">

            <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
              <h1 class="display-4">Programming languages</h1>
              <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam dignissimos vero aspernatur suscipit modi.</p>
            </div>

          <div class="card-group">
            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/php.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>PHP</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/python.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Python</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/javascript.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Javascript</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/ruby.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Ruby</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/java.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Java</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>
          </div>

          <div class="card-group">
            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" style="background-color: red;"
                class="background" />

              <img :src="public_path + '/images/node.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>NodeJS</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>


            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/cPlusPlus.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>C++</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/go.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Go</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/swift.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>Swift</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>

            <div class="card profile-card-1">
              <img src="https://jitheshpr.com/wp-content/uploads/2016/07/gra.png" alt="profile-sample1" class="background" />
              <img :src="public_path + '/images/csharp.png'" alt="profile-image" class="profile" />
              <div class="card-content">
                <span>C#</span>
                <!-- <div class="icon-block"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"> <i class="fa fa-twitter"></i></a><a href="#"> <i class="fa fa-google-plus"></i></a></div> -->
              </div>
            </div>
          </div>


        </div>

      </div>



      <div class="album py-5 bg-light">
        <div class="container-fluid" id="welcome-map">

            <div class="pricing-header px-3 py-3 pb-md-4 mx-auto text-center">
              <h1 class="display-4">Search by Map</h1>
              <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam dignissimos vero aspernatur suscipit modi.</p>
            </div>

          <div class="row featurette" style="background-image: url('https://images.unsplash.com/photo-1487581424120-18f3611a63e6?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=eb87a25dcd5110b903616b765084274a&auto=format&fit=crop&w=1452&q=80')">
            <div class="col-md-7">
              <h2 class="featurette-heading">First featurette heading.
                <span class="text-muted">It'll blow your mind.</span>
              </h2>
              <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent
                commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
            <div class="col-md-5">
              <!-- <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px;"
          src="https://images.unsplash.com/photo-1487581424120-18f3611a63e6?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=eb87a25dcd5110b903616b765084274a&auto=format&fit=crop&w=1452&q=80"
          data-holder-rendered="true"> -->
            </div>
          </div>
        </div>

      </div>
    </main>



    <!--Footer-->
    <!--footer starts from here-->
    <footer class="footer">
      <div class="container bottom_border">
        <div class="row">
          <div class=" col-sm-4 col-md col-sm-4  col-12 col">
            <h5 class="headin5_amrc col_white_amrc pt2">Find us</h5>
            <!--headin5_amrc-->
            <p class="mb10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
              standard dummy text ever since the 1500s</p>
            <p>
              <i class="fa fa-location-arrow"></i> 9878/25 sec 9 rohini 35 </p>
            <p>
              <i class="fa fa-phone"></i> +91-9999878398 </p>
            <p>
              <i class="fa fa fa-envelope"></i> info@example.com </p>


          </div>


          <div class=" col-sm-4 col-md  col-6 col">
            <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
            <!--headin5_amrc-->
            <ul class="footer_ul_amrc">
              <li>
                <a href="#">Image Rectoucing</a>
              </li>
              <li>
                <a href="#">Clipping Path</a>
              </li>
              <li>
                <a href="#">Hollow Man Montage</a>
              </li>
              <li>
                <a href="#">Ebay & Amazon</a>
              </li>
              <li>
                <a href="#">Hair Masking/Clipping</a>
              </li>
              <li>
                <a href="#">Image Cropping</a>
              </li>
            </ul>
            <!--footer_ul_amrc ends here-->
          </div>


          <div class=" col-sm-4 col-md  col-6 col">
            <h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
            <!--headin5_amrc-->
            <ul class="footer_ul_amrc">
              <li>
                <a href="#">Remove Background</a>
              </li>
              <li>
                <a href="#">Shadows & Mirror Reflection</a>
              </li>
              <li>
                <a href="#">Logo Design</a>
              </li>
              <li>
                <a href="#">Vectorization</a>
              </li>
              <li>
                <a href="#">Hair Masking/Clipping</a>
              </li>
              <li>
                <a href="#">Image Cropping</a>
              </li>
            </ul>
            <!--footer_ul_amrc ends here-->
          </div>


          <div class=" col-sm-4 col-md  col-12 col">
            <h5 class="headin5_amrc col_white_amrc pt2">Follow us</h5>
            <!--headin5_amrc ends here-->

            <ul class="footer_ul2_amrc">
              <li>
                <a href="#">
                  <i class="fab fa-twitter fleft padding-right"></i>
                </a>
                <p>Lorem Ipsum is simply dummy text of the printing...
                  <a href="#">https://www.lipsum.com/</a>
                </p>
              </li>
              <li>
                <a href="#">
                  <i class="fab fa-twitter fleft padding-right"></i>
                </a>
                <p>Lorem Ipsum is simply dummy text of the printing...
                  <a href="#">https://www.lipsum.com/</a>
                </p>
              </li>
              <li>
                <a href="#">
                  <i class="fab fa-twitter fleft padding-right"></i>
                </a>
                <p>Lorem Ipsum is simply dummy text of the printing...
                  <a href="#">https://www.lipsum.com/</a>
                </p>
              </li>
            </ul>
            <!--footer_ul2_amrc ends here-->
          </div>
        </div>
      </div>


      <div class="container">
        <ul class="foote_bottom_ul_amrc">
          <li>
            <a href="#">Home</a>
          </li>
          <li>
            <a href="#">About</a>
          </li>
          <li>
            <a href="#">Services</a>
          </li>
          <li>
            <a href="#">Pricing</a>
          </li>
          <li>
            <a href="#">Blog</a>
          </li>
          <li>
            <a href="#">Contact</a>
          </li>
        </ul>
        <!--foote_bottom_ul_amrc ends here-->
        <p class="text-center">Copyright @ 2018 | Designed With by
          <a href="https://nexseed.net/">Nexseed</a>
        </p>

        <ul class="social_footer_ul">
          <li>
            <a href="#">
              <i class="fa fa-facebook-f"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-twitter"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-linkedin"></i>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-instagram"></i>
            </a>
          </li>
        </ul>
        <!--social_footer_ul ends here-->
      </div>

    </footer>

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
  .pt-5,
  .py-5 {
    padding-top: 4rem !important;
  }

  .featurette {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
  }

  #welcome-map {
    margin-top: 1rem;
    margin-bottom: 1rem;
  }

  #card-hero-carousel {
    box-shadow: 0 4px 6px rgba(50, 50, 93, .21), 0 1px 3px rgba(0, 0, 0, .4);
    color: #281483;
    background: linear-gradient(135deg, #8969d0 0%, #281483 100%);
    background: #fff;
    font-family: Raleway, sans-serif;
  }

  #card-hero-carousel .btn-hero-opp {
    border-color: #bab9bd;
    line-height: 40px;
    padding: 0 14px;
    -webkit-box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
    box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
    font-size: 1em;
    font-weight: 600;
    color: #716b6b;
    background-color: white;
    font-family: Raleway, sans-serif;
    border-radius: 4px;
  }

  #card-hero-carousel .btn-hero-nt-opp {
    background: #3c2693;
    border-color: #8c8c8c;
    line-height: 40px;
    padding: 0 14px;
    -webkit-box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
    box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
    font-size: 1em;
    font-weight: 600;
    color: #fff;
    font-family: Raleway, sans-serif;
    border-radius: 4px;
  }

  #card-hero-carousel .card-title {
    font-weight: 600;
    margin-bottom: 0.625rem;
    text-transform: uppercase;
    font-family: Verdana, sans-serif;
  }

  .hero-center-title .pt-lg {
    padding-top: 9rem !important
  }

  #company-cont-body{
    margin-top: 12rem;
  }

  .display-4 {
      font-size: 2.5rem;
      font-weight: 300;
      line-height: 1.2;
  }

</style>
