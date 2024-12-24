<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
   data-theme-mode="color" style="--primary-rgb: 17,28,67;">
   <head>
      <!-- Meta Data -->
      <meta charset="UTF-8">
      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> xBug </title>
      <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
      <meta name="Author" content="Spruko Technologies Private Limited">
      <!-- Favicon -->
      <link rel="icon" href="../../assets/images/brand-logos/favicon.ico" type="image/x-icon">
      <!-- Bootstrap Css -->
      <link id="style" href="../../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Style Css -->
      <link href="../../assets/css/styles.css" rel="stylesheet">
      <!-- Icons Css -->
      <link href="../../assets/css/icons.css" rel="stylesheet">
      <!-- Node Waves Css -->
      <link href="../../assets/libs/node-waves/waves.min.css" rel="stylesheet">
      <!-- SwiperJS Css -->
      <link rel="stylesheet" href="../../assets/libs/swiper/swiper-bundle.min.css">
      <!-- Color Picker Css -->
      <link rel="stylesheet" href="../../assets/libs/flatpickr/flatpickr.min.css">
      <link rel="stylesheet" href="../../assets/libs/@simonwep/pickr/themes/nano.min.css">
      <!-- Choices Css -->
      <link rel="stylesheet" href="../../assets/libs/choices.js/public/../../assets/styles/choices.min.css">
      <script>
         if (localStorage.ynexlandingdarktheme) {
             document.querySelector("html").setAttribute("data-theme-mode", "dark")
         }
         if (localStorage.ynexlandingrtl) {
             document.querySelector("html").setAttribute("dir", "rtl")
             document.querySelector("#style")?.setAttribute("href", "../../../assets/libs/bootstrap/css/bootstrap.rtl.min.css");
         }
      </script>
   </head>
   <body class="landing-body">
      <div class="landing-page-wrapper">
         <!-- Start::app-sidebar -->
         <header class="app-header">
            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">
               <!-- Start::header-content-left -->
               <div class="header-content-left">
                  <!-- Start::header-element -->
                  <div class="header-element">
                     <div class="horizontal-logo d-flex justify-content-center align-items-center">
                        <a href="#" class="header-logo">
                        <span class="fw-bold text-primary">xBug</span>
                        </a>
                     </div>
                  </div>
                  <!-- End::header-element -->
                  <!-- Start::header-element -->
                  <div class="header-element">
                     <!-- Start::header-link -->
                     <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                     <span class="open-toggle">
                     <i class="ri-menu-3-line fs-20"></i>
                     </span>
                     </a>
                     <!-- End::header-link -->
                  </div>
                  <!-- End::header-element -->
               </div>
               <!-- End::header-content-left -->
               <!-- Start::header-content-right -->
               <div class="header-content-right">
                  <!-- Start::header-element -->
                  <div class="header-element align-items-center">
                     <!-- Start::header-link|switcher-icon -->
                     <div class="btn-list d-lg-none d-block">
                        <a href="/login" class="btn btn-primary">
                        Sign In
                        </a>
                     </div>
                     <!-- End::header-link|switcher-icon -->
                  </div>
                  <!-- End::header-element -->
               </div>
               <!-- End::header-content-right -->
            </div>
            <!-- End::main-header-container -->
         </header>
         <aside class="app-sidebar sticky" id="sidebar">
            <div class="container-xl">
               <!-- Start::main-sidebar -->
               <div class="main-sidebar">
                  <!-- Start::nav -->
                  <nav class="main-menu-container nav nav-pills sub-open">
                     <div class="landing-logo-container">
                        <div class="horizontal-logo">
                           <a href="index.html" class="header-logo">
                              <h4 class="text-primary fw-bold">xBug</h4>
                           </a>
                        </div>
                     </div>
                     <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                           width="24" height="24" viewBox="0 0 24 24">
                           <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                     </div>
                     <ul class="main-menu">
                        <!-- Start::slide -->
                        <li class="slide">
                           <a class="side-menu__item" href="/#home">
                           <span class="side-menu__label">Home</span>
                           </a>
                        </li>
                        <!-- End::slide -->
                        <!-- Start::slide -->
                        <li class="slide">
                           <a href="/#about" class="side-menu__item">
                           <span class="side-menu__label">About</span>
                           </a>
                        </li>
                        <li class="slide">
                           <a href="/view-microlearning" class="side-menu__item">
                           <span class="side-menu__label">Content</span>
                           </a>
                        </li>
                        <li class="slide">
                           <a href="/jobstreet" class="side-menu__item">
                               <span class="side-menu__label">Jobstreet</span>
                           </a>
                       </li>
                        <!-- End::slide -->
                        <!-- Start::slide -->
                        <!-- End::slide -->
                     </ul>
                     <div class="slide-right" id="slide-right">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                           width="24" height="24" viewBox="0 0 24 24">
                           <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                           </path>
                        </svg>
                     </div>
                     <div class="d-lg-flex d-none">
                        <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                           <a href="/login" class="btn btn-wave btn-primary">
                           Sign In
                           </a>
                        </div>
                     </div>
                  </nav>
                  <!-- End::nav -->
               </div>
               <!-- End::main-sidebar -->
            </div>
         </aside>
         <!-- End::app-sidebar -->
         <!-- Start::app-content -->
         <div class="main-content landing-main px-0">
            <div class="landing-banner" id="home">
               <section class="section pb-0">
                  <div class="container main-banner-container">
                     <div class="row justify-content-center text-center">
                        <div class="col-xxl-7 col-xl-7 col-lg-8">
                           <div class="">
                              <h6 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">14+ </span>Content for Course and Tranning</h6>
                              <p class="fs-18 mb-5 op-8 fw-normal text-fixed-white">Register &amp; get free access to create your content and <br>submit your content with few easy steps.</p>
                              <div class="mb-3 custom-form-group">
                                 <input type="text" class="form-control form-control-lg shadow-sm" placeholder="your keyword...." 
                                    aria-label="Recipient's username">
                                 <div class="custom-form-btn bg-transparent">
                                    <button class="btn btn-primary border-0" type="button"><i class="bi bi-search me-sm-2"></i> <span>Search</span></button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
            </div>
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="row g-3 mt-4">
                           @foreach($contents as $content)
                              <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card custom-card" style="width: 100%;">
                                       <!-- Display image or fallback -->
                                       @if($content->image)
                                          <img src="{{ asset($content->image) }}" class="card-img-top" alt="{{ $content->name }}" style="height: 180px; object-fit: cover;">
                                       @else
                                          <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white" style="height: 180px; font-size: 48px; font-weight: bold;">
                                                {{ strtoupper(substr($content->name, 0, 1)) }}
                                          </div>
                                       @endif

                                       <div class="card-body">
                                          <h6 class="card-title fw-semibold">{{ $content->name }}</h6>
                                          <p class="card-text text-muted">{{ $content->content_type_name }}</p>
                                          <a href="javascript:void(0);" class="btn btn-primary">Read More</a>
                                       </div>
                                       <div class="card-footer">
                                          <span class="card-text">Last updated {{ \Carbon\Carbon::parse($content->created_at)->diffForHumans() }}</span>
                                       </div>
                                    </div>
                              </div>
                           @endforeach
                        </div>
                  </div>
               </div>
            </div>


            <div class="modal fade" id="viewContent" tabindex="-1"
               aria-labelledby="viewContent" data-bs-keyboard="false"
               aria-hidden="true">
               <div class="modal-dialog modal-dialog-scrollable modal-lg">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel1">How to be a backend Software Engineer
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                           aria-label="Close"></button>
                     </div>
                     <div class="modal-body">
                        <iframe src="https://en.wikipedia.org/wiki/Abdul_Rashid_Hassan" width="100%" height="500px" frameborder="0" title="About Page"></iframe>

                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                           Libero
                           ipsum quasi, error quibusdam debitis maiores hic eum? Vitae
                           nisi
                           ipsa maiores fugiat deleniti quis reiciendis veritatis.
                        </p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ea
                           voluptatibus, ipsam quo est rerum modi quos expedita facere,
                           ex
                           tempore fuga similique ipsa blanditiis et accusamus
                           temporibus
                           commodi voluptas! Nobis veniam illo architecto expedita quam
                           ratione quaerat omnis. In, recusandae eos! Pariatur,
                           deleniti
                           quis ad nemo ipsam officia temporibus, doloribus fuga
                           asperiores
                           ratione distinctio velit alias hic modi praesentium aperiam
                           officiis eaque, accusamus aut. Accusantium assumenda,
                           commodi
                           nulla provident asperiores fugit inventore iste amet aut
                           placeat
                           consequatur reprehenderit. Ratione tenetur eligendi, quis
                           aperiam dolores magni iusto distinctio voluptatibus minus a
                           unde
                           at! Consequatur voluptatum in eaque obcaecati, impedit
                           accusantium ea soluta, excepturi, quasi quia commodi
                           blanditiis?
                           Qui blanditiis iusto corrupti necessitatibus dolorem fugiat
                           consequuntur quod quo veniam? Labore dignissimos reiciendis
                           accusamus recusandae est consequuntur iure.
                        </p>
                        <p>Lorem ipsum dolor sit amet.</p>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger"
                           data-bs-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- End:: Section-11 -->
            <div class="text-center landing-main-footer py-3 bg-light">
               <span class="text-dark  mb-0">All
               rights
               reserved Copyright © <span id="year">2024</span> xBug - Protected with Advanced Security
               </span>
            </div>
         </div>
         <!-- End::app-content -->
      </div>
      <div class="scrollToTop">
         <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
      </div>
      <div id="responsive-overlay"></div>
      <!-- Popper JS -->
      <script src="../../assets/libs/@popperjs/core/umd/popper.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Color Picker JS -->
      <script src="../../assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>
      <!-- Choices JS -->
      <script src="../../assets/libs/choices.js/public/../../assets/scripts/choices.min.js"></script>
      <!-- Swiper JS -->
      <script src="../../assets/libs/swiper/swiper-bundle.min.js"></script>
      <!-- Defaultmenu JS -->
      <script src="../../assets/js/defaultmenu.min.js"></script>
      <!-- Internal Landing JS -->
      <script src="../../assets/js/landing.js"></script>
      <!-- Node Waves JS-->
      <script src="../../assets/libs/node-waves/waves.min.js"></script>
      <!-- Sticky JS -->
      <script src="../../assets/js/sticky.js"></script>
   </body>
</html>