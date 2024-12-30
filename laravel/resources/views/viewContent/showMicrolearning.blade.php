<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
   data-theme-mode="color" style="--primary-rgb: 17,28,67;">
   <head>
      <!-- Meta Data -->
      <meta charset="UTF-8">
      <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> xBug </title>
      <meta name="Description" content="xBug">
      <meta name="Author" content="xBug Inc">
      <!-- Favicon -->
      <link rel="icon" href="../../assets/images/logo.ico" type="image/x-icon">

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
                           <img src="../../assets/images/logo.png" width="55" height="50" alt="logo"></img>
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
                              <img src="../../assets/images/logo.png" width="55" height="50" alt="logo"></img>
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
                           <a href="/view-content" class="side-menu__item">
                           <span class="side-menu__label">Content</span>
                           </a>
                        </li>
                        <li class="slide">
                           <a href="/jobstreet" class="side-menu__item">
                               <span class="side-menu__label">Discover</span>
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
                              <h6 class="landing-banner-heading mb-3"><span class="text-secondary fw-bold">+ </span>Content for Course and Tranning</h6>
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
            <div class="container d-flex justify-content-center">
                <div class="card custom-card" style="width: 100%; max-width: 600px; border: 2px solidrgb(0, 0, 0); border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"">
                    <!-- Card Header -->
                    <div class="card-header justify-content-between m-0">
                        <div class="card-title text-center">
                            {{ $contents->name }}
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Display image or fallback -->
                        @if($contents->image)
                        <img src="{{ asset('storage/' . $contents->image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $contents->name }}" 
                                             onerror="console.log('Image failed to load:', this.src);" 
                                             style="height: 180px; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center card-img-top bg-primary text-white mb-3" style="height: 200px; font-size: 48px; font-weight: bold;">
                                {{ strtoupper(substr($contents->name, 0, 1)) }}
                            </div>
                        @endif

                        <!-- Content Information -->
                        <p class="text-muted mb-2">{{ $contents->content_type_name }}</p>
                        <p class="text-muted"><em id="descriptionPreview">{{ Str::limit($contents->desc, 100, '...') }}</em></p>

                        <!-- Read More Button -->
                        <div id="formattedContent" class="content-preview mt-3"></div>

                        <a href="{{ url('/view-content/' . $microLearningSlug) }}" class="btn btn-primary">Back</a>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer text-center">
                        <span class="text-muted">Last updated {{ \Carbon\Carbon::parse($contents->created_at)->diffForHumans() }}</span>
                    </div>
                </div>
            </div>



            <!-- <div class="modal fade" id="viewContent" tabindex="-1"
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
            </div> -->

       
            <!-- Modal for Read More -->
            <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="contentModalLabel">Content Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <div class="modal-body" id="modalContent">
                        <!-- Content preview will be dynamically inserted here -->
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

      <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Fetch the content
                const formattedContent = `{{ addslashes($contents->content) }}`; // Replace this with the dynamic content if needed.

                // Function to format the content
                function formatContent(content) {
                    let formattedHtml = "";
                    const sections = content.split("\n\n"); // Assuming sections are separated by double new lines
                    sections.forEach((section, index) => {
                        const headerMatch = section.match(/\*\*\*(.*?)\*\*\*/); // Match header in ***
                        if (headerMatch) {
                            const header = headerMatch[1]; // Extract header
                            const body = section.replace(/\*\*\*(.*?)\*\*\*/, '').trim(); // Remove header and extract body

                            // Append formatted section to preview
                            formattedHtml += `
                                <div class="preview-section">
                                    <h2>Step ${index + 1}: ${header}</h2>
                                    <p>${body}</p>
                                </div>
                            `;
                        } else {
                            // If no header is found, treat the entire section as normal text
                            formattedHtml += `<p>${section}</p>`;
                        }
                    });
                    return formattedHtml;
                }

                // Display the formatted content
                const contentHtml = formatContent(formattedContent);
                document.getElementById("formattedContent").innerHTML = contentHtml;
            });
    </script>

   </body>
</html>